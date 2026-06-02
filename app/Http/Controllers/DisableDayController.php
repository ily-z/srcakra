<?php

namespace App\Http\Controllers;

use App\Models\DisableDay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DisableDayController extends Controller
{
    public function index(): View
    {
        $disableDays = DisableDay::query()->latest()->paginate(15);
        return view('admin.disable-days.index', compact('disableDays'));
    }

    public function create(): View
    {
        return view('admin.disable-days.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date', 'unique:tabel_disable_day,tanggal'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        DisableDay::create($request->only(['tanggal', 'keterangan']));

        return redirect()->route('admin.disable-days.index')->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function edit(DisableDay $disableDay): View
    {
        return view('admin.disable-days.edit', compact('disableDay'));
    }

    public function update(Request $request, DisableDay $disableDay): RedirectResponse
    {
        $request->validate([
            'tanggal' => ['required', 'date', 'unique:tabel_disable_day,tanggal,' . $disableDay->id_disday . ',id_disday'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $disableDay->update($request->only(['tanggal', 'keterangan']));

        return redirect()->route('admin.disable-days.index')->with('success', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(DisableDay $disableDay): RedirectResponse
    {
        $disableDay->delete();
        return redirect()->route('admin.disable-days.index')->with('success', 'Hari libur berhasil dihapus.');
    }
}
