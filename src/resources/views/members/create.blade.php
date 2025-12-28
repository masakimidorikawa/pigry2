<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>

    <!-- CSS 読み込み -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>PiGLy<br>新規会員登録</h2>
    <p>STEP1 アカウント情報の登録</p>
    
<form action="/register/step1" method="POST">
    @csrf



        <div class="form-group">
            <label>名前：</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
<div class="form-group">
    <label>メールアドレス：</label><br>
    <input type="text" name="email" value="{{ old('email') }}">

    @foreach ($errors->get('email') as $message)
        <div class="error-message">{{ $message }}</div>
    @endforeach
</div>



        <div class="form-group">
            <label>パスワード：</label><br>
            <input type="password" name="password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">次に進む</button>
    </form>

    <p><a href="/login">ログインはこちら</a></p>
</div>

</body>
</html>