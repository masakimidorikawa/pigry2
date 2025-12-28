<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="form-container">
    <h2>PiGLy<br>ログイン</h2>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>メールアドレス：</label>
            <input type="text" name="email" value="{{ old('email') }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>パスワード：</label>
            <input type="password" name="password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">ログイン</button>
    </form>

    <p><a href="{{ route('register.step1') }}">新規登録はこちら</a></p>
</div>

</body>
</html>