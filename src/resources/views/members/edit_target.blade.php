@extends('layouts.admin')
<style>
.target-edit-container {
    max-width: 400px;
    margin: 120px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    text-align: center;
}

.target-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #ec4899;
}

.form-group {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
}

.form-group input {
    width: 100px;
    padding: 8px;
    font-size: 18px;
    border: 1px solid #ccc;
    border-radius: 6px;
    text-align: right;
}

.unit-label {
    font-size: 18px;
    color: #555;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.back-button {
    background: #ccc;
    color: #333;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
}

.register-button {
    background: linear-gradient(to right, #ec4899, #d946ef);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}
.error-message {
    color: red;
    font-size: 14px;
    margin-top: 4px;
}

</style>
@section('content')
<div class="target-edit-container">
    <h2 class="target-title">目標体重設定</h2>


    <form action="{{ route('target.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <input type="text" name="target_weight"
                   value="{{ old('target_weight', $target_weight) }}" required>
            <span class="unit-label">kg</span>
        </div>
            {{-- ★ エラー表示 --}}
    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <p class="error-message">{{ $error }}</p>
            @endforeach
        </div>
    @endif


        <div class="form-actions">
            <a href="{{ route('mypage') }}" class="back-button">戻る</a>
            <button type="submit" class="register-button">更新</button>
        </div>
    </form>
</div>

@endsection
