<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $categories = Kategori::query()
            ->when($request->filled('nama'), fn($q) => $q->where('nama', 'LIKE', '%' . $request->nama . '%'))
            ->when($request->filled('kode'), fn($q) => $q->where('kode', 'LIKE', '%' . $request->kode . '%'))
            ->latest()->paginate(20)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form', ['category' => new Kategori]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:kategoris,kode',
        ]);
        Kategori::create($data);
        return redirect()->route('categories.index')->with('success', 'Berhasil Menambahkan Kategori');
    }

    public function show(Kategori $category)
    {
        $category->load('items');
        return view('categories.show', compact('category'));
    }

    public function edit(Kategori $category)
    {
        return view('categories.form', compact('category'));
    }

    public function update(Request $request, Kategori $category)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:kategoris,kode,' . $category->id,
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Berhasil Mengubah Kategori');
    }

    public function destroy(Kategori $category)
    {
        $category->items()->detach();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Berhasil Menghapus Kategori');
    }
}
