<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function index()
    {
        $filter['search'] = request()->keyword;

        $volumes = Volume::query()
            ->filter($filter)
            ->latest()
            ->paginate(10);

        return view('pages.volumes.index', compact('volumes'));
    }

    public function create()
    {
        return view('pages.volumes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_volume' => 'required|string|max:255',
        ], [
            'nama_volume.required' => 'Nama Volume wajib diisi.',
            'nama_volume.max' => 'Nama Volume maksimal 255 karakter.',
        ]);

        Volume::create($request->only('nama_volume'));

        return redirect()->route('volumes.index')->withSuccess('Volume berhasil ditambahkan');
    }

    public function show(Volume $volume)
    {
        //
    }

    public function edit(Volume $volume)
    {
        return view('pages.volumes.edit', compact('volume'));
    }

    public function update(Request $request, Volume $volume)
    {
        $request->validate([
            'nama_volume' => 'required|string|max:255',
        ]);

        $volume->update($request->only('nama_volume'));

        return redirect()->route('volumes.index')->withSuccess('Volume berhasil diperbarui');
    }

    public function destroy(Volume $volume)
    {
        $volume->delete();
        return redirect()->route('volumes.index')->withSuccess('Volume berhasil dihapus');
    }
}
