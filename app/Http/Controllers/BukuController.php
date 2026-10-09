<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Menggunakan Eager Loading (with) untuk memitigasi N+1 Query Problem
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        // Mengambil semua data kategori untuk ditampilkan di dropdown form
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Validasi ketat sisi server: ISBN unik, judul min 5 karakter, stok tidak boleh minus
        $validated = $request->validate([
            'isbn' => 'required|string|max:20|unique:bukus,isbn',
            'judul' => 'required|string|min:5|max:150',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|digits:4',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        // Pengecualian unique ID pada ISBN agar tidak bentrok saat buku di-update tanpa mengubah ISBN
        $validated = $request->validate([
            'isbn' => 'required|string|max:20|unique:bukus,isbn,' . $buku->id,
            'judul' => 'required|string|min:5|max:150',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|digits:4',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}