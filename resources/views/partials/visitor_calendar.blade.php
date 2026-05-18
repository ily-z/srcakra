@php
    $interactive = $calendarInteractive ?? false;
    $routeName = $visitorCalendarRoute ?? 'home';
@endphp

<div class="overflow-hidden rounded-xl border border-[#5C4033]/20 bg-white shadow-md">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-[#5C4033]/5 px-4 py-3">
        <h2 class="text-lg font-semibold text-[#5C4033]">Kalender kunjungan</h2>
        <div class="flex items-center gap-2 text-sm">
            <a
                href="{{ route($routeName, ['month' => $calendarPrevYm]) }}"
                class="rounded-md border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50"
            >&larr;</a>
            <span class="min-w-[10rem] text-center font-medium text-slate-800">{{ $calendarMonthLabel }}</span>
            <a
                href="{{ route($routeName, ['month' => $calendarNextYm]) }}"
                class="rounded-md border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50"
            >&rarr;</a>
        </div>
    </div>

    <div class="overflow-x-auto p-4">
        <table class="w-full min-w-[320px] border-collapse text-center text-sm">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="border border-slate-100 py-2">Sen</th>
                    <th class="border border-slate-100 py-2">Sel</th>
                    <th class="border border-slate-100 py-2">Rab</th>
                    <th class="border border-slate-100 py-2">Kam</th>
                    <th class="border border-slate-100 py-2">Jum</th>
                    <th class="border border-slate-100 py-2">Sab</th>
                    <th class="border border-slate-100 py-2">Min</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calendarWeeks as $week)
                    <tr>
                        @foreach ($week as $cell)
                            @if ($cell === null)
                                <td class="h-14 border border-slate-50 bg-slate-50/50 md:h-16"></td>
                            @else
                                @php
                                    $isMuted = $cell['disabled'];
                                @endphp
                                <td class="h-14 align-top border border-slate-100 p-1 md:h-16">
                                    @if ($interactive && ! $isMuted)
                                        <button
                                            type="button"
                                            class="flex h-full w-full flex-col items-center justify-center rounded-lg p-1 text-slate-800 hover:bg-[#5C4033]/10"
                                            data-calendar-date="{{ $cell['date'] }}"
                                        >
                                            <span class="text-sm font-semibold">{{ $cell['day'] }}</span>
                                            @if (($cell['count'] ?? 0) > 0)
                                                <span class="mt-0.5 inline-block min-w-[1.25rem] rounded-full bg-[#5C4033]/15 px-1 text-[10px] font-medium text-[#5C4033]">{{ $cell['count'] }}</span>
                                            @else
                                                <span class="mt-0.5 text-[10px] text-slate-400">—</span>
                                            @endif
                                        </button>
                                    @else
                                        <div
                                            class="flex h-full flex-col items-center justify-center rounded-lg p-1 {{ $isMuted ? 'bg-rose-50 text-rose-800/80' : 'text-slate-800' }}"
                                            @if($interactive && $isMuted) title="Tanggal libur / ditutup" @endif
                                        >
                                            <span class="text-sm font-semibold">{{ $cell['day'] }}</span>
                                            @if ($isMuted)
                                                <span class="mt-0.5 text-[10px]">Tutup</span>
                                            @elseif (($cell['count'] ?? 0) > 0)
                                                <span class="mt-0.5 inline-block min-w-[1.25rem] rounded-full bg-emerald-100 px-1 text-[10px] font-medium text-emerald-900">{{ $cell['count'] }}</span>
                                            @else
                                                <span class="mt-0.5 text-[10px] text-slate-400">—</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="border-t border-slate-100 px-4 py-3 text-xs text-slate-600">
        Angka pada tanggal = total pengunjung terjadwal (estimasi dari pengajuan). Tanggal bertanda
        <span class="font-semibold text-rose-700">Tutup</span> tidak dapat dipilih.
        @if ($interactive)
            Tap tanggal yang tersedia untuk mengisi <span class="font-medium">Tanggal kunjungan</span> di form.
        @endif
    </p>
</div>
