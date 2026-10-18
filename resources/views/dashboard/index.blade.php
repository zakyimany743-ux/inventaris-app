@extends('layouts.app')

@section('title', 'Dashboard - Aplikasi Manajemen Inventaris')

@section('content')
<div class="card">
    <h1 class="page-title">👋 Selamat Datang, {{ $userName }}!</h1>
    <p class="page-subtitle">Email: {{ $userEmail }}</p>

    <p style="margin-bottom: 20px; color: #4b5563; line-height: 1.6;">
        Selamat datang di <strong>Aplikasi Manajemen Inventaris Toko Perlengkapan Komputer</strong>.
        Aplikasi ini membantu Anda mengelola data barang, mengelompokkannya berdasarkan kategori,
        serta memantau jumlah stok yang tersedia. Gunakan menu di bawah untuk mulai mengelola
        inventaris toko Anda.
    </p>

    @php
        $categoryCount = \App\Models\Category::count();
        $itemCount     = \App\Models\Item::count();
        $totalStock    = \App\Models\Item::sum('stock');
        $totalValue    = \App\Models\Item::selectRaw('SUM(price * stock) as total')->value('total') ?? 0;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value">{{ $categoryCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Barang</div>
            <div class="stat-value">{{ $itemCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Stok</div>
            <div class="stat-value">{{ $totalStock }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nilai Inventaris</div>
            <div class="stat-value">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="header-actions">
        <h2 style="font-size: 18px;">Menu Akses Cepat</h2>
    </div>

    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('categories.index') }}" class="btn btn-primary">
            📂 Kelola Kategori
        </a>
        <a href="{{ route('items.index') }}" class="btn btn-success">
            📦 Kelola Barang
        </a>
    </div>
</div>

<div class="card">
    <h2 style="font-size: 18px; margin-bottom: 15px;">📋 Informasi Aplikasi</h2>
    <table>
        <tr>
            <td style="width: 200px;"><strong>Framework</strong></td>
            <td>Laravel 12</td>
        </tr>
        <tr>
            <td><strong>Database</strong></td>
            <td>MySQL / MariaDB</td>
        </tr>
        <tr>
            <td><strong>Authentication</strong></td>
            <td>Session-based dengan hashing password (bcrypt)</td>
        </tr>
        <tr>
            <td><strong>Middleware</strong></td>
            <td>Halaman inventaris dilindungi middleware <code>auth</code></td>
        </tr>
        <tr>
            <td><strong>Relasi Database</strong></td>
            <td>One-to-Many: <code>categories</code> (1) → <code>items</code> (N)</td>
        </tr>
        <tr>
            <td><strong>Eloquent Relationship</strong></td>
            <td><code>hasMany()</code> &amp; <code>belongsTo()</code></td>
        </tr>
    </table>
</div>
@endsection
