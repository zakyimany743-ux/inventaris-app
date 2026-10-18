@extends('layouts.app')

@section('title', 'Tambah Kategori - Inventaris App')

@section('content')
<div class="card">
    <h1 class="page-title">📂 Tambah Kategori Baru</h1>
    <p class="page-subtitle">Lengkapi form di bawah untuk menambah kategori baru</p>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori *</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name') }}"
                   placeholder="contoh: Aksesori, Perangkat Komputer, dll" required autofocus>
            @error('name')
                <small style="color: #dc2626; font-size: 12px;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-success">💾 Simpan Kategori</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
</div>
@endsection
