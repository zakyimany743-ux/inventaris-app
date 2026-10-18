<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Manajemen Inventaris')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background: #f4f6f9; color: #333; min-height: 100vh; }
        .navbar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-size: 20px; font-weight: 700; }
        .navbar-menu { display: flex; gap: 15px; align-items: center; }
        .navbar-menu a { color: white; text-decoration: none; padding: 8px 12px; border-radius: 6px; transition: background 0.2s; font-size: 14px; }
        .navbar-menu a:hover { background: rgba(255,255,255,0.2); }
        .navbar-user { font-size: 14px; opacity: 0.95; margin-right: 10px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .page-title { font-size: 24px; font-weight: 700; margin-bottom: 5px; color: #1f2937; }
        .page-subtitle { color: #6b7280; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; font-size: 14px; }
        td { font-size: 14px; }
        tr:hover { background: #f9fafb; }
        .btn { display: inline-block; padding: 9px 18px; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: #4f46e5; color: white; }
        .btn-primary:hover { background: #4338ca; }
        .btn-success { background: #10b981; color: white; }
        .btn-success:hover { background: #059669; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #374151; font-size: 14px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; transition: border-color 0.2s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-gray { background: #f3f4f6; color: #4b5563; }
        .actions { display: flex; gap: 8px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #4f46e5; }
        .stat-label { color: #6b7280; font-size: 13px; margin-bottom: 5px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #1f2937; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .empty-state { text-align: center; padding: 40px; color: #9ca3af; }
        .login-wrapper { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 400px; }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h1 { color: #4f46e5; font-size: 24px; margin-bottom: 5px; }
        .login-header p { color: #6b7280; font-size: 14px; }
        .demo-credentials { background: #f0f9ff; border: 1px solid #bae6fd; padding: 12px; border-radius: 6px; margin-top: 20px; font-size: 13px; color: #075985; }
        .demo-credentials strong { display: block; margin-bottom: 5px; }
        .price { font-weight: 600; color: #059669; }
        .stock-low { color: #dc2626; font-weight: 600; }
    </style>
</head>
<body>
    @auth
    <nav class="navbar">
        <div class="navbar-brand">📦 Inventaris App</div>
        <div class="navbar-menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('categories.index') }}">Kategori</a>
            <a href="{{ route('items.index') }}">Barang</a>
            <span class="navbar-user">👋 {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">⚠️ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
