<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RukunWarga;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class RtRwController extends Controller
{
    public function index()
    {
        $rukunWargas = RukunWarga::orderBy('nama_rw')->get();
        return view('dashboard.rt_rw.index', compact('rukunWargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rw' => 'required|string|max:255',
            'jumlah_rt' => 'required|integer|min:0',
            'estimasi_penduduk' => 'required|integer|min:0',
        ]);

        $totalPenduduk = \App\Models\Setting::where('key', 'demografi_total')->value('value') ?? 0;
        $currentSum = \App\Models\RukunWarga::sum('estimasi_penduduk');

        if (($currentSum + $request->estimasi_penduduk) > $totalPenduduk) {
            return redirect()->back()->withErrors(['estimasi_penduduk' => 'Akses ditolak: Total jiwa seluruh RW tidak boleh melebihi Total Penduduk ('.number_format($totalPenduduk, 0, ',', '.').' Jiwa).'])->withInput();
        }

        $rw = RukunWarga::create($request->only('nama_rw', 'jumlah_rt', 'estimasi_penduduk'));

        ActivityLogger::log('CREATE', 'Data RT/RW', "Menambahkan data Rukun Warga: {$rw->nama_rw}", [
            'rw_id' => $rw->id,
            'jumlah_rt' => $rw->jumlah_rt
        ]);

        return redirect()->route('dashboard.demographics.index')->with('success', 'Data Rukun Warga berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rw' => 'required|string|max:255',
            'jumlah_rt' => 'required|integer|min:0',
            'estimasi_penduduk' => 'required|integer|min:0',
        ]);

        $totalPenduduk = \App\Models\Setting::where('key', 'demografi_total')->value('value') ?? 0;
        $currentSum = \App\Models\RukunWarga::where('id', '!=', $id)->sum('estimasi_penduduk');

        if (($currentSum + $request->estimasi_penduduk) > $totalPenduduk) {
            return redirect()->back()->withErrors(['estimasi_penduduk' => 'Akses ditolak: Total jiwa seluruh RW tidak boleh melebihi Total Penduduk ('.number_format($totalPenduduk, 0, ',', '.').' Jiwa).'])->withInput();
        }

        $rw = RukunWarga::findOrFail($id);
        $rw->update($request->only('nama_rw', 'jumlah_rt', 'estimasi_penduduk'));

        ActivityLogger::log('UPDATE', 'Data RT/RW', "Mengubah data Rukun Warga: {$rw->nama_rw}", [
            'rw_id' => $rw->id
        ]);

        return redirect()->route('dashboard.demographics.index')->with('success', 'Data Rukun Warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rw = RukunWarga::findOrFail($id);
        $namaRw = $rw->nama_rw;
        $rw->delete();

        ActivityLogger::log('DELETE', 'Data RT/RW', "Menghapus data Rukun Warga: {$namaRw}");

        return redirect()->route('dashboard.demographics.index')->with('success', 'Data Rukun Warga berhasil dihapus.');
    }
}
