<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Menampilkan daftar kategori, diurutkan abjad, dengan pagination (10 per halaman)
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        
        // Nanti kita akan buat view 'categories.index'
        return view('categories.index', compact('categories')); 
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // VALIDASI SERVER-SIDE (Sesuai syarat UTS)
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:categories,name'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori ini sudah terdaftar. Gunakan nama lain.',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            // Unik, KECUALI untuk ID kategori yang sedang diedit ini
            'name' => ['required', 'string', 'max:50', 'unique:categories,name,' . $category->id],
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // PROTEKSI: Cek apakah kategori ini sudah dipakai oleh Produk
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Gagal dihapus! Kategori ini masih digunakan oleh beberapa produk.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}