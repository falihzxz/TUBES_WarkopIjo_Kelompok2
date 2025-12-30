<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $menuCount = Menu::count();
        $mejaCount = Meja::count();
        $mejaTersedia = Meja::where('status', 'tersedia')->count();
        $mejaDipakai = Meja::where('status', 'dipakai')->count();
        $orderCount = Order::count();
        $orderMenunggu = Order::where('status', 'menunggu')->count();

        return view('admin.dashboard', compact('menuCount', 'mejaCount', 'mejaTersedia', 'mejaDipakai', 'orderCount', 'orderMenunggu'));
    }

    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Form tambah menu
    public function create()
    {
        return view('admin.menu.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'foto' => 'nullable|url'
        ]);

        Menu::create($request->all());

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    // Form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'foto' => 'nullable|url'
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }

    public function mejaIndex()
    {
        $mejas = Meja::all();
        return view('admin.meja.index', compact('mejas'));
    }
}
