@extends('layouts.admin')
<style>
.button-wrapper {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 24px;
}

.delete-button-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 16px;
    padding-right: 20px;
}

.back-button,
.update-button,
.delete-button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: 0.2s;
}

.back-button {
    background-color: #ccc;
    color: #333;
    text-decoration: none;
}


.delete-button {
    background-color: transparent; /* 背景は透明のままでもOK */
    border: none;
    font-size: 15px;
    cursor: pointer;
    color: #ff4d4d;
     margin-top: -60px; /* 数値を調整して好みの位置に */

}




</style>
@section('content')
<div class="log-edit-container">
    <h2 class="log-title"><br>Weight Log</h2>
    <p class="log-subtitle">日付・体重・カロリー・運動内容を編集できます。</p>

    {{-- 更新フォーム --}}
<form action="{{ route('record.update', ['id' => $record->id]) }}" method="POST">
    @csrf
    @method('PUT')


        {{-- 日付 --}}
        <div class="form-group">
            <label for="date">日付：</label>
<input type="date" name="date" value="{{ old('date', $record->date) }}">
        </div>

        {{-- 体重 --}}
        <div class="form-group">
            <label for="weight">体重（kg）：</label>
                <input type="text" name="weight" value="{{ old('weight', $record->weight) }}">

        </div>

        {{-- 摂取カロリー --}}
        <div class="form-group">
            <label for="calories">摂取カロリー（cal）：</label>
             <input type="text" name="calories" value="{{ old('calories', $record->calories) }}">


        </div>

        {{-- 運動時間 --}}
        <div class="form-group">
            <label for="exercise_time">運動時間：</label>
            <input type="text" name="exercise_time" value="{{ old('exercise_time', $record->exercise_time) }}">

        </div>

        {{-- 運動内容 --}}
        <div class="form-group">
            <label for="exercise_content">運動内容：</label>
            <input type="text" name="exercise_content" value="{{ old('exercise_content', $record->exercise_content) }}">
        </div>

        {{-- ボタン --}}
<div class="button-wrapper">
    <div class="center-buttons">
        <a href="{{ route('mypage') }}" class="back-button">戻る</a>
        <button type="submit" class="update-button">更新</button>
    </div>
</div>

<div class="delete-button-wrapper">
    <form action="{{ route('record.destroy', ['id' => $record->id]) }}"
          method="POST"
          onsubmit="return confirm('本当に削除しますか？');"
          class="delete-form-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">🗑️ </button>
    </form>
</div>


@endsection


