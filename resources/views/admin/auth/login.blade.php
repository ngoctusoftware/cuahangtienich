<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị - {{ $siteName ?? 'ZEK SHOP' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v=2" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-4">
                <span class="brand-mark d-inline-flex mb-3" style="width:46px;height:46px;font-size:20px;"><i class="fas fa-bolt"></i></span>
                <h4 class="text-white fw-bold mb-1">{{ $siteName ?? 'ZEK SHOP' }} Admin</h4>
                <div class="page-subtitle">Đăng nhập để vào trang quản trị</div>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-admin-primary w-100 mt-2">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>
