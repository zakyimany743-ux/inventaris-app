@extends('layouts.app')

@section('title', 'Daftar Kategori - Inventaris App')

@section('content')
<div class="card">
    <div class="header-actions">
        <div>
            <h1 class="page-title">📂 Daftar Kategori</h1>
            <p class="page-subtitle">Kelola kategori barang inventaris Anda</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    @if($categories->isEmpty())
        <div class="empty-state">
            <p style="font-size: 16px;">Belum ada kategori.</p>
            <p style="margin-top: 10px;">Klik tombol "Tambah Kategori" untuk membuat kategori pertama Anda.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Nama Kategori</th>
                    <th style="width: 120px;">Jumlah Barang</th>
                    <th style="width: 180px;">Dibuat</th>
                    <th style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <span class="badge badge-blue">{{ $category->name }}</span>
                    </td>
                    <td>
                        @if($category->items_count > 0)
                            <span class="badge badge-blue">{{ $category->items_count }} barang</span>
                        @else
                            <span class="badge badge-gray">0 barang</span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori &quot;{{ $category->name }}&quot;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
