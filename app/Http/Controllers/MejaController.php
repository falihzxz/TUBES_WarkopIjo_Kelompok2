<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('admin.meja.index', compact('mejas'));
    }

    public function create()
    {
        return view('admin.meja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas'
        ]);

        Meja::create([
            'nomor_meja' => $request->nomor_meja
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan');
    }

    public function edit(Meja $meja)
    {
        return view('admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:mejas,nomor_meja,' . $meja->id
        ]);

        $meja->update([
            'nomor_meja' => $request->nomor_meja
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diupdate');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus');
    }

    /**
     * Release a table: mark status as 'tersedia'.
     */
    public function release(Meja $meja)
    {
        if ($meja->status !== 'tersedia') {
            $meja->update(['status' => 'tersedia']);
            return redirect()->route('admin.meja.index')->with('success', 'Status meja berhasil diubah menjadi tersedia');
        }

        return redirect()->route('admin.meja.index')->with('success', 'Meja sudah dalam status tersedia');
    }
}
