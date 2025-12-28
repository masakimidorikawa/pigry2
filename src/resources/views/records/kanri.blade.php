@extends('layouts.app')
.edit-icon {
    margin-left: 10px;
    text-decoration: none;
    font-size: 18px;
}
@section('content')
<div class="form-container">
    <h2>データ管理</h2>

    <form action="{{ route('record.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>日付</label>
            <input type="date" name="date" value="{{ old('date') }}">
        </div>

        <div class="form-group">
            <label>体重 (kg)</label>
            <input type="text" name="weight" value="{{ old('weight') }}">
        </div>

        <div class="form-group">
            <label>食事摂取カロリー (cal)</label>
            <input type="number" name="calories" value="{{ old('calories') }}">
        </div>

        <div class="form-group">
            <label>運動時間 (例: 00:15)</label>
            <input type="text" name="exercise_time" value="{{ old('exercise_time') }}">
        </div>

        <button type="submit">保存</button>
    </form>

    <p><a href="{{ route('mypage') }}">戻る</a></p>
</div>
@endsection
@foreach ($records as $record)
    <div class="record-item">
        <span>{{ $record->date }} / {{ $record->weight }}kg / {{ $record->calories }}cal</span>

        <!-- 編集ボタン（ペンアイコン） -->
        <a href="{{ route('record.edit', $record->id) }}" class="edit-icon">
            ✏️
        </a>
    </div>
@endforeach
