<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PIGLY</title>

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<header class="fixed-header">
    <div class="header-left">
        <a href="{{ route('mypage') }}" class="logo">PiGLy</a>
    </div>

    <div class="header-right">
        <a href="{{ route('target.edit') }}" class="header-button">
            <span class="icon">⚙️</span> 目標体重設定
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="header-button logout-button">
                <span class="icon">🚪</span> ログアウト
            </button>
        </form>
    </div>
</header>

<div class="content">
    @yield('content')
</div>

</body>
</html>
