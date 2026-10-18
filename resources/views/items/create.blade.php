@extends('layouts.app')

@section('title', 'Tambah Barang - Inventaris App')

@section('content')
<div class="card">
    <h1 class="page-title">📦 Tambah Barang Baru</h1>
    <p class="page-subtitle">Lengkapi form di bawah untuk menambah barang baru</p>

    @if($categories->isEmpty())
        <div class="alert alert-error">
            ⚠️ Belum ada kategori. Anda harus membuat minimal satu kategori terlebih dahulu
            sebelum menambah barang.
            <a href="{{ route('categories.create') }}" style="color: #991b1b; text-decoration: underline;">Buat kategori di sini</a>.
        </div>
    @else
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Barang *</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name') }}"
                   placeholder="contoh: Keyboard, Mouse, Monitor" required autofocus>
            @error('name')
                <small style="color: #dc2626; font-size: 12px;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori *</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @if(old('category_id') == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small style="color: #dc2626; font-size: 12px;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp) *</label>
            <input type="number" name="price" id="price" step="0.01" min="0.01"
                   value="{{ old('price') }}"
                   placeholder="contoh: 150000" required>
            <small style="color: #6b7280; font-size: 12px;">Harga harus berupa angka lebih besar dari nol.</small>
            @error('price')
                <small style="color: #dc2626; font-size: 12px; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok *</label>
            <input type="number" name="stock" id="stock" min="0" step="1"
                   value="{{ old('stock', 0) }}"
                   placeholder="contoh: 10" required>
            <small style="color: #6b7280; font-size: 12px;">Stok harus berupa bilangan bulat minimal nol.</small>
            @error('stock')
                <small style="color: #dc2626; font-size: 12px; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-success">💾 Simpan Barang</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
    @endif
</div>
@endsection
