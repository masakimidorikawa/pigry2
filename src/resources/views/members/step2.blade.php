<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員登録 STEP2</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="form-container">
    <h2>PiGLy<br>STEP2</h2>
    <p>現在の体重と目標体重を入力してください。</p>

    <form action="{{ route('register.step2.store') }}" method="POST">
        @csrf

<div class="form-group">
    <label>現在の体重（kg）：</label>
    <input type="text" name="current_weight" step="0.1" value="{{ old('current_weight') }}">
@if ($errors->has('current_weight'))
    @foreach ($errors->get('current_weight') as $error)
        <div class="error-message">{{ $error }}</div>
    @endforeach
@endif

</div>

<div class="form-group">
    <label>目標体重（kg）：</label>
    <input type="text" name="target_weight" step="0.1" value="{{ old('target_weight') }}">
@if ($errors->has('target_weight'))
    @foreach ($errors->get('target_weight') as $error)
        <div class="error-message">{{ $error }}</div>
    @endforeach
@endif


</div>


        <button type="submit">アカウント作成</button>
    </form>

    <p><a href="{{ route('register.step1') }}">← STEP1 に戻る</a></p>
</div>

</body>
</html>