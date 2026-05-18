<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterface;
use App\Models\DisableDay;
use App\Models\Kunjungan;
use App\Models\Payment;
use App\Models\Pendaftar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    private const PRICE_PER_PERSON = 10000;

    public function home(Request $request): View
    {
        $data = $this->visitorCalendarPayload($request);
        $data['visitorCalendarRoute'] = 'home';

        return view('index', $data);
    }

    public function index(Request $request): View
    {
        $data = $this->visitorCalendarPayload($request);
        $data['visitorCalendarRoute'] = 'booking.index';

        return view('booking.index', $data);
    }

    /**
     * @return array<string, mixed>
     */
    private function visitorCalendarPayload(Request $request): array
    {
        $disabledDatesAll = DisableDay::query()
            ->pluck('tanggal')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->values();

        $monthYm = $request->query('month');
        $month = ($monthYm && preg_match('/^\d{4}-\d{2}$/', $monthYm))
            ? Carbon::createFromFormat('Y-m', $monthYm)->startOfMonth()
            : now()->startOfMonth();

        $from = $month->copy()->startOfMonth()->toDateString();
        $to = $month->copy()->endOfMonth()->toDateString();

        $visitCounts = Pendaftar::query()
            ->whereBetween('tanggal_kunjungan', [$from, $to])
            ->selectRaw('tanggal_kunjungan, SUM(jumlah_pengunjung) as total')
            ->groupBy('tanggal_kunjungan')
            ->get()
            ->mapWithKeys(fn ($row) => [
                Carbon::parse($row->tanggal_kunjungan)->toDateString() => (int) $row->total,
            ]);

        $disabledInMonth = DisableDay::query()
            ->whereBetween('tanggal', [$from, $to])
            ->pluck('tanggal')
            ->map(fn ($date) => Carbon::parse($date)->toDateString());

        return [
            'disabledDates' => $disabledDatesAll,
            'calendarMonth' => $month,
            'calendarMonthYm' => $month->format('Y-m'),
            'calendarMonthLabel' => $month->locale('id')->translatedFormat('F Y'),
            'calendarWeeks' => $this->buildCalendarWeeks($month, $visitCounts, $disabledInMonth),
            'calendarPrevYm' => $month->copy()->subMonth()->format('Y-m'),
            'calendarNextYm' => $month->copy()->addMonth()->format('Y-m'),
        ];
    }

    /**
     * @param  Collection<string,int>  $visitCounts
     * @param  Collection<int,string>  $disabledDates
     * @return array<int, array<int, array<string, mixed>|null>>
     */
    private function buildCalendarWeeks(CarbonInterface $month, Collection $visitCounts, Collection $disabledDates): array
    {
        $start = $month->copy()->startOfMonth();
        $daysInMonth = $month->daysInMonth;
        $leading = $start->dayOfWeekIso - 1;

        $cells = [];
        for ($i = 0; $i < $leading; $i++) {
            $cells[] = null;
        }
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = $start->copy()->day($d)->toDateString();
            $cells[] = [
                'day' => $d,
                'date' => $date,
                'count' => (int) ($visitCounts[$date] ?? 0),
                'disabled' => $disabledDates->contains($date),
            ];
        }
        while (count($cells) % 7 !== 0) {
            $cells[] = null;
        }

        return array_chunk($cells, 7);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_pendaftar' => ['required', 'in:personal,instansi'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'nama' => ['nullable', 'string', 'max:255'],
            'nama_instansi' => ['nullable', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'tujuan_kunjungan' => ['required', 'string'],
            'surat_pengajuan' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'jumlah_pengunjung' => ['nullable', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:cash,dana,gopay,shopeepay'],
        ]);

        $isDisabled = DisableDay::query()->whereDate('tanggal', $validated['tanggal_kunjungan'])->exists();
        if ($isDisabled) {
            return back()->withInput()->withErrors([
                'tanggal_kunjungan' => 'Tanggal kunjungan tidak tersedia (museum tutup).',
            ]);
        }

        $isPersonal = $validated['jenis_pendaftar'] === 'personal';
        if ($isPersonal && empty($validated['nama'])) {
            return back()->withInput()->withErrors(['nama' => 'Nama wajib diisi untuk kunjungan personal.']);
        }
        if (! $isPersonal && empty($validated['nama_instansi'])) {
            return back()->withInput()->withErrors(['nama_instansi' => 'Nama instansi wajib diisi untuk kunjungan instansi.']);
        }

        $jumlahPengunjung = $isPersonal ? 1 : (int) ($validated['jumlah_pengunjung'] ?? 1);
        if (! $isPersonal && ! $request->hasFile('surat_pengajuan')) {
            return back()->withInput()->withErrors(['surat_pengajuan' => 'Surat pengajuan wajib untuk instansi.']);
        }

        $suratPath = $request->hasFile('surat_pengajuan')
            ? $request->file('surat_pengajuan')->store('surat_pengajuan', 'public')
            : null;

        $result = DB::transaction(function () use ($validated, $isPersonal, $jumlahPengunjung, $suratPath) {
            $pendaftar = Pendaftar::create([
                'jenis_pendaftar' => $validated['jenis_pendaftar'],
                'tanggal_daftar' => now()->toDateString(),
                'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                'nama' => $isPersonal ? $validated['nama'] : null,
                'nama_instansi' => $isPersonal ? null : $validated['nama_instansi'],
                'alamat' => $validated['alamat'],
                'email' => $validated['email'],
                'tujuan_kunjungan' => $validated['tujuan_kunjungan'],
                'surat_pengajuan' => $suratPath,
                'jumlah_pengunjung' => $jumlahPengunjung,
                'status_pengajuan' => 'pending',
            ]);

            $payment = Payment::create([
                'id_pendaftar' => $pendaftar->id_pendaftar,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'total' => self::PRICE_PER_PERSON * $jumlahPengunjung,
            ]);

            return [$pendaftar, $payment];
        });

        [$pendaftar, $payment] = $result;

        return redirect()->route('booking.payment', $payment->id_payment)
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function payment(Payment $payment): View
    {
        $payment->load('pendaftar', 'kunjungan');
        return view('booking.payment', ['payment' => $payment]);
    }

    public function midtransCallbackSimulation(Payment $payment): RedirectResponse
    {
        if ($payment->status !== 'paid') {
            DB::transaction(function () use ($payment) {
                $payment->update(['status' => 'paid']);
                $pendaftar = $payment->pendaftar;
                $pendaftar->update(['status_pengajuan' => 'approved']);
                $kunjungan = $payment->kunjungan ?: $this->createKunjunganFromPayment($payment, $pendaftar);
                $this->sendInvoice($kunjungan);
            });
        }

        return redirect()->route('booking.receipt', $payment->id_payment)
            ->with('success', 'Pembayaran online disimulasikan berhasil.');
    }

    public function receipt(Payment $payment): View
    {
        $payment->load('pendaftar', 'kunjungan');
        abort_unless($payment->kunjungan, 404);

        return view('booking.receipt', ['payment' => $payment, 'kunjungan' => $payment->kunjungan]);
    }

    private function createKunjunganFromPayment(Payment $payment, Pendaftar $pendaftar): Kunjungan
    {
        return Kunjungan::create([
            'tanggal_daftar' => $pendaftar->tanggal_daftar,
            'tanggal_kunjungan' => $pendaftar->tanggal_kunjungan,
            'nama' => $pendaftar->nama,
            'nama_instansi' => $pendaftar->nama_instansi,
            'email' => $pendaftar->email,
            'tujuan_kunjungan' => $pendaftar->tujuan_kunjungan,
            'surat_pengajuan' => $pendaftar->surat_pengajuan,
            'jumlah_pengunjung' => $pendaftar->jumlah_pengunjung,
            'payment_method' => $payment->payment_method,
            'id_payment' => $payment->id_payment,
            'status_kunjungan' => 'waiting',
            'qr_token' => (string) Str::uuid(),
        ]);
    }

    private function sendInvoice(Kunjungan $kunjungan): void
    {
        try {
            $name = $kunjungan->nama ?: $kunjungan->nama_instansi ?: 'Pengunjung';
            $receiptUrl = route('booking.receipt', $kunjungan->id_payment);
            Mail::raw("Halo {$name}, invoice dan QR kunjungan Anda: {$receiptUrl}", function ($message) use ($kunjungan) {
                $message->to($kunjungan->email)->subject('Invoice & QR Kunjungan Museum');
            });
        } catch (\Throwable) {
            // Keep booking flow non-blocking when mail server is unavailable.
        }
    }
}
