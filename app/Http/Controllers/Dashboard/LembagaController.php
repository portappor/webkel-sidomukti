<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Models\LembagaMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class LembagaController extends Controller
{
    public function index()
    {
        $lembagas = Lembaga::orderBy('nama_lembaga', 'asc')->get();
        return view('dashboard.lembagas.index', compact('lembagas'));
    }

    public function create()
    {
        return view('dashboard.lembagas.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:255',
            'dasar_hukum' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string|max:255',
            'foto_logo' => 'nullable|image|max:2048',
            'profil' => 'nullable|string',
            'visi_misi' => 'nullable|string',
            'tupoksi' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $fotoPath = null;
            if ($request->hasFile('foto_logo')) {
                $fotoPath = $request->file('foto_logo')->store('lembagas', 'public');
            }

            $lembaga = Lembaga::create([
                'nama_lembaga' => $request->nama_lembaga,
                'singkatan' => $request->singkatan,
                'dasar_hukum' => $request->dasar_hukum,
                'alamat_kantor' => $request->alamat_kantor,
                'foto_logo' => $fotoPath,
                'profil' => $request->profil,
                'visi_misi' => $request->visi_misi,
                'tupoksi' => $request->tupoksi,
                'status' => $request->has('status') ? true : false,
            ]);

            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $index => $member) {
                    if (!empty($member['nama'])) {
                        $lembaga->members()->create([
                            'nama' => $member['nama'],
                            'jabatan' => $member['jabatan'] ?? null,
                            'pendidikan' => $member['pendidikan'] ?? null,
                            'urutan' => $index,
                        ]);
                    }
                }
            }

            DB::commit();
            ActivityLogger::log('CREATE', 'Lembaga Kemasyarakatan', "Menambahkan lembaga: {$lembaga->nama_lembaga}");

            return redirect()->route('dashboard.lembagas.index')->with('success', 'Lembaga berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $lembaga = Lembaga::with('members')->findOrFail($id);
        return view('dashboard.lembagas.form', compact('lembaga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:255',
            'dasar_hukum' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string|max:255',
            'foto_logo' => 'nullable|image|max:2048',
            'profil' => 'nullable|string',
            'visi_misi' => 'nullable|string',
            'tupoksi' => 'nullable|string',
        ]);

        $lembaga = Lembaga::findOrFail($id);

        try {
            DB::beginTransaction();

            $fotoPath = $lembaga->foto_logo;
            if ($request->hasFile('foto_logo')) {
                if ($fotoPath) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file('foto_logo')->store('lembagas', 'public');
            }

            $lembaga->update([
                'nama_lembaga' => $request->nama_lembaga,
                'singkatan' => $request->singkatan,
                'dasar_hukum' => $request->dasar_hukum,
                'alamat_kantor' => $request->alamat_kantor,
                'foto_logo' => $fotoPath,
                'profil' => $request->profil,
                'visi_misi' => $request->visi_misi,
                'tupoksi' => $request->tupoksi,
                'status' => $request->has('status') ? true : false,
            ]);

            // Sync members
            $lembaga->members()->delete();
            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $index => $member) {
                    if (!empty($member['nama'])) {
                        $lembaga->members()->create([
                            'nama' => $member['nama'],
                            'jabatan' => $member['jabatan'] ?? null,
                            'pendidikan' => $member['pendidikan'] ?? null,
                            'urutan' => $index,
                        ]);
                    }
                }
            }

            DB::commit();
            ActivityLogger::log('UPDATE', 'Lembaga Kemasyarakatan', "Mengubah data lembaga: {$lembaga->nama_lembaga}");

            return redirect()->route('dashboard.lembagas.index')->with('success', 'Lembaga berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $lembaga = Lembaga::findOrFail($id);
        
        try {
            if ($lembaga->foto_logo) {
                Storage::disk('public')->delete($lembaga->foto_logo);
            }
            
            $nama = $lembaga->nama_lembaga;
            $lembaga->delete();
            
            ActivityLogger::log('DELETE', 'Lembaga Kemasyarakatan', "Menghapus lembaga: {$nama}");
            
            return redirect()->route('dashboard.lembagas.index')->with('success', 'Lembaga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus lembaga.');
        }
    }
}
