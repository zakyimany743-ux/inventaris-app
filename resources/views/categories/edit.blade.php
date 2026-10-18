@extends('layouts.app')

@section('title', 'Edit Kategori - Inventaris App')

@section('content')
<div class="card">
    <h1 class="page-title">✏️ Edit Kategori</h1>
    <p class="page-subtitle">Perbarui informasi kategori "{{ $category->name }}"</p>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori *</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $category->name) }}"
                   placeholder="masukkan nama kategori" required autofocus>
            @error('name')
                <small style="color: #dc2626; font-size: 12px;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">💾 Update Kategori</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
</div>
@endsection
