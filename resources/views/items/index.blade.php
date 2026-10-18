@extends('layouts.app')

@section('title', 'Daftar Barang - Inventaris App')

@section('content')
<div class="card">
    <div class="header-actions">
        <div>
            <h1 class="page-title">📦 Daftar Barang</h1>
            <p class="page-subtitle">Kelola data barang inventaris beserta kategorinya</p>
        </div>
        <a href="{{ route('items.create') }}" class="btn btn-success">+ Tambah Barang</a>
    </div>

    @if($items->isEmpty())
        <div class="empty-state">
            <p style="font-size: 16px;">Belum ada barang.</p>
            <p style="margin-top: 10px;">Klik tombol "Tambah Barang" untuk membuat barang pertama Anda.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th style="width: 150px;">Harga</th>
                    <th style="width: 100px;">Stok</th>
                    <th style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>
                        @if($item->category)
                            <span class="badge badge-blue">{{ $item->category->name }}</span>
                        @else
                            <span class="badge badge-gray">Tanpa Kategori</span>
                        @endif
                    </td>
                    <td class="price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>
                        @if($item->stock <= 5)
                            <span class="stock-low">{{ $item->stock }} (rendah)</span>
                        @else
                            {{ $item->stock }}
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus barang &quot;{{ $item->name }}&quot;?');">
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
