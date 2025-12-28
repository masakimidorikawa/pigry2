@extends('layouts.admin')
<style>
.header-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 25px;
    background-color: rgba(255, 255, 255, 0.91);
    border-bottom: 1px solid #ccc;
}


.logo-text {
    font-size: 24px;
    font-weight: bold;
    color: #ec4899;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.goal-weight {
    font-size: 16px;
    font-weight: bold;
    color: #555;
}

.logout-form {
    margin: 0;
}

.logout-button {
    background-color:rgb(196, 196, 196);
    color: black;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.logout-button:hover {
    background-color: #db2777;
}

.mypage-container {
    max-width: 800px;
    margin: 120px auto 40px; /* ← 上だけ120pxにする */
    font-family: 'Helvetica', sans-serif;
}


.summary-cards {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.card {
    background-color: #fce7f3;
    padding: 20px;
    border-radius: 10px;
    width: 30%;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card h3 {
    margin-bottom: 10px;
    font-size: 16px;
    color: #ec4899;
}

.card p {
    font-size: 18px;
    font-weight: bold;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.data-table th, .data-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.data-table th {
    background-color: #f9fafb;
    color: #555;
}

.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.add-button {
    background-color: #ec4899;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;

    display: inline-block; /* ← 横並びに必須 */
    margin: 0;             /* ← 右寄せを消す */
    width: fit-content;
}




.add-button:hover {
    background-color: #ec4899;
}
.goal-weight-button {
    font-size: 16px;
    font-weight: bold;
    color: black;
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 6px;
    background-color:rgb(196, 196, 196);
}

.goal-weight-button:hover {
    background-color:rgb(97, 90, 96);
}
.modal-toggle {
    display: none;
}

.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

/* チェックが入ったら表示 */
.modal-toggle:checked + .modal-overlay {
    display: flex;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
}

.close-button {
    margin-top: 20px;
    background: #aaa;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    display: inline-block;
}
.required-tag {
    background-color: #e53e3e;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 6px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
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
    cursor: pointer;
}

.register-button {
    background: linear-gradient(to right, #ec4899, #d946ef);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}
.top-bar {
    display: flex;
    justify-content: space-between; /* 左：検索フォーム / 右：追加ボタン */
    align-items: center;
    margin-bottom: 20px;
}

.search-form {
    display: flex;
    align-items: center;
    gap: 10px;
}
.search-form input[type="date"] {
    width: 150px;
        color: #666;
}
.search-form button {
    background-color:rgb(129, 129, 129);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.search-form button:hover {
    background-color: #db2777;
}


</style>

@section('header')
<div class="header-bar">
    <div class="header-left">
        <span class="logo-text">PIGLY</span>
    </div>
<div class="header-right">

<a href="{{ route('target.edit') }}" class="goal-weight-button">
    ⚙目標体重設定
</a>


        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-button">ログアウト</button>
        </form>
    </div>
</div>
@endsection


@section('content')
<div class="mypage-container">

    <div class="summary-cards">
        <div class="card">
            <h3>目標体重</h3>
            <p>{{ $target_weight }}kg</p>
        </div>
        <div class="card">
            <h3>目標まで</h3>
            <p>{{ $to_goal }}kg</p>
        </div>
        <div class="card">
            <h3>最新体重</h3>
            <p>{{ $latest_weight }}kg</p>
        </div>
    </div>
<div class="top-bar">
<form action="{{ route('mypage') }}" method="GET" class="search-form">
    <input type="date" name="from" value="{{ request('from') }}">
    <span class="range-mark">〜</span>
    <input type="date" name="to" value="{{ request('to') }}">
    <button type="submit">検索</button>
</form>


    <label for="modalToggle" class="add-button">データ追加</label>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>日付</th>
            <th>体重</th>
            <th>食事摂取カロリー</th>
            <th>運動時間</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
        <tr>
            <td>{{ $record->date }}</td>
            <td>{{ $record->weight }}kg</td>
            <td>{{ $record->calories }}cal</td>
            <td>{{ $record->exercise_time }}</td>
            <td>
                <a href="{{ route('record.edit', ['id' => $record->id]) }}" title="編集">

                    ✏️
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



<input type="checkbox" id="modalToggle" class="modal-toggle">

<div class="modal-overlay">
    <div class="modal-content">

<h2>Weight Logを追加</h2>

<form action="{{ route('record.store') }}" method="POST">
    @csrf

<div class="form-group">
    <label>日付 <span class="required-tag">必須</span></label>
    <input type="date" name="date" value="{{ old('date') }}">
    @error('date')
        <div class="input-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>体重 <span class="required-tag">必須</span></label>
 <input type="text" name="weight" value="{{ old('weight', '') }}">

@if ($errors->has('weight'))
    @foreach ($errors->get('weight') as $msg)
        <div class="input-error">{{ $msg }}</div>
    @endforeach
@endif

</div>

<div class="form-group">
    <label>摂取カロリー <span class="required-tag">必須</span></label>
    <input type="text" name="calories" >
@if ($errors->has('calories'))
    @foreach ($errors->get('calories') as $msg)
        <div class="input-error">{{ $msg }}</div>
    @endforeach
@endif

</div>

<div class="form-group">
    <label>運動時間<span class="required-tag">必須</span></label>
    <input type="time" name="exercise_time" value="{{ old('exercise_time') }}">
    @error('exercise_time')
        <div class="input-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>運動内容</label>
    <textarea name="exercise_detail" class="input-textarea">{{ old('exercise_detail') }}</textarea>
    @error('exercise_detail')
        <div class="input-error">{{ $message }}</div>
    @enderror
</div>

{{-- ★ エラーがあるときだけモーダルを自動で開く --}}
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modalToggle').checked = true;
    });
</script>
@endif




    <div class="form-actions">
        <label for="modalToggle" class="back-button">戻る</label>
        <button type="submit" class="register-button">登録</button>
    </div>
</form>
    </div>
</div>
<div class="pagination-wrapper">
    {{ $records->links('pagination::bootstrap-4') }}
</div>



