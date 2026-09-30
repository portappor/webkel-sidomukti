<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class AgendaController extends Controller
{
    public function index()
    {
        if (class_exists(\App\Models\Agenda::class)) { \App\Models\Agenda::cleanupExpired(); }

        $agendas = Agenda::orderBy('date', 'desc')->paginate(10);
        return view('dashboard.agendas.index', compact('agendas'));
    }

    private function formatTimeInput(?string $time): ?string
    {
        if (!$time) return null;
        $val = str_replace('.', ':', trim($time));
        if (preg_match('/^\d{1,2}:\d{2}$/', $val)) {
            return $val . ' WIB';
        }
        return $val;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:date',
            'time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        if (!empty($validated['time'])) {
            $validated['time'] = $this->formatTimeInput($validated['time']);
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = $this->formatTimeInput($validated['end_time']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('agendas', 'public');
        }

        $validated['is_active'] = true;
        $agenda = Agenda::create($validated);

        ActivityLogger::log('CREATE', 'Agenda', "Menambahkan agenda baru: {$agenda->title}", [
            'agenda_id' => $agenda->id,
            'date' => $agenda->date
        ]);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:date',
            'time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        if (!empty($validated['time'])) {
            $validated['time'] = $this->formatTimeInput($validated['time']);
        }
        if (!empty($validated['end_time'])) {
            $validated['end_time'] = $this->formatTimeInput($validated['end_time']);
        }

        if ($request->hasFile('image')) {
            if ($agenda->image && Storage::disk('public')->exists($agenda->image)) {
                Storage::disk('public')->delete($agenda->image);
            }
            $validated['image'] = $request->file('image')->store('agendas', 'public');
        }

        $agenda->update($validated);

        ActivityLogger::log('UPDATE', 'Agenda', "Memperbarui agenda: {$agenda->title}", [
            'agenda_id' => $agenda->id,
            'date' => $agenda->date
        ]);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $title = $agenda->title;

        if ($agenda->image && Storage::disk('public')->exists($agenda->image)) {
            Storage::disk('public')->delete($agenda->image);
        }

        $agenda->delete();

        ActivityLogger::log('DELETE', 'Agenda', "Menghapus agenda: {$title}");

        return redirect()->back()->with('success', 'Agenda berhasil dihapus!');
    }
}
