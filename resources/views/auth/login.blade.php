<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arsip Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { width: 400px; border: none; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; }
        .login-header { background: #007bff; color: white; padding: 30px 20px; text-align: center; }
        .login-body { padding: 30px; background: white; }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="login-header">
            <h4><i class="fas fa-archive"></i> Arsip Surat</h4>
            <p class="mb-0 small text-white-50">Sistem Informasi Manajemen Arsip</p>
        </div>
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger small p-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required value="admin@admin.com">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required value="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk Sistem</button>
            </form>
        </div>
    </div>
</body>
</html>
