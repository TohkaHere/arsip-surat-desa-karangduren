<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arsip Surat Desa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .sidebar .menu-item {
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: #333;
            display: block;
            transition: background-color 0.3s;
        }
        
        .sidebar .menu-item:hover {
            background-color: #f8f9fa;
            color: #333;
        }
        
        .sidebar .menu-item.active {
            background-color: #e3f2fd;
            border-right: 4px solid #2196f3;
        }
        
        .content-area {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        
        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }
        
        .search-input {
            flex: 1;
            max-width: 400px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .btn-search {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-search:hover {
            background-color: #5a6268;
        }
        
        .table-container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            padding: 12px;
        }
        
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }
        
        .btn-action {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-unduh {
            background-color: #ffc107;
            color: black;
        }
        
        .btn-lihat {
            background-color: #007bff;
            color: white;
        }
        
        .btn-action:hover {
            opacity: 0.8;
            color: inherit;
        }
        
        .btn-arsipkan {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-arsipkan:hover {
            background-color: #218838;
            color: white;
        }
        
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <h5 class="fw-bold">Menu</h5>
                    <hr>
                </div>
                
                <a href="{{ route('surat.index') }}" class="menu-item {{ request()->routeIs('surat.index') ? 'active' : '' }}">
                    <i class="fas fa-archive me-2"></i> Arsip
                </a>
                
                <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fas fa-tags me-2"></i> Kategori Surat
                </a>
                
                <a href="{{ route('about') }}" class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <i class="fas fa-info-circle me-2"></i> About
                </a>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sweet Alert for confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('scripts')
</body>
</html>