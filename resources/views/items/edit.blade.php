@extends('layouts.app')

@section('title', 'Edit Barang - Inventaris App')

@section('content')
<div class="card">
    <h1 class="page-title">✏️ Edit Barang</h1>
    <p class="page-subtitle">Perbarui informasi barang "{{ $item->name }}"</p>

    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Barang *</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $item->name) }}"
                   placeholder="masukkan nama barang" required autofocus>
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
                        @if(old('category_id', $item->category_id) == $category->id) selected @endif>
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
                   value="{{ old('price', $item->price) }}"
                   placeholder="contoh: 150000" required>
            <small style="color: #6b7280; font-size: 12px;">Harga harus berupa angka lebih besar dari nol.</small>
            @error('price')
                <small style="color: #dc2626; font-size: 12px; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok *</label>
            <input type="number" name="stock" id="stock" min="0" step="1"
                   value="{{ old('stock', $item->stock) }}"
                   placeholder="contoh: 10" required>
            <small style="color: #6b7280; font-size: 12px;">Stok harus berupa bilangan bulat minimal nol.</small>
            @error('stock')
                <small style="color: #dc2626; font-size: 12px; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">💾 Update Barang</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
</div>
@endsection
