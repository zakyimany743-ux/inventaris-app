<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar semua barang beserta nama kategori.
     */
    public function index()
    {
        // Ambil semua barang dengan relasi kategori (eager loading)
        $items = Item::with('category')->latest()->get();

        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form tambah barang.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        return view('items.create', compact('categories'));
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input sesuai ketentuan ujian:
        // - nama barang wajib
        // - harga > 0
        // - stok >= 0 bilangan bulat
        // - category_id harus ada di tabel categories
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|gt:0',
            'stock'       => 'required|integer|min:0',
        ], [
            'name.required'        => 'Nama barang tidak boleh kosong.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak tersedia di database.',
            'price.required'       => 'Harga wajib diisi.',
            'price.gt'             => 'Harga harus berupa angka lebih besar dari nol.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.integer'        => 'Stok harus berupa bilangan bulat.',
            'stock.min'            => 'Stok minimal nol.',
        ]);

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|gt:0',
            'stock'       => 'required|integer|min:0',
        ], [
            'name.required'        => 'Nama barang tidak boleh kosong.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak tersedia di database.',
            'price.required'       => 'Harga wajib diisi.',
            'price.gt'             => 'Harga harus berupa angka lebih besar dari nol.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.integer'        => 'Stok harus berupa bilangan bulat.',
            'stock.min'            => 'Stok minimal nol.',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Menghapus barang.
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang "' . $item->name . '" berhasil dihapus.');
    }
}
