<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Validator;
class RecordController extends Controller
{

    public function kanri()
    {
        return view('records.kanri');
    }

public function store(Request $request)
{
    // ログイン中のユーザーIDを取得
    $memberId = session('member_id');

    if (!$memberId) {
        return redirect()->route('login')->with('error', 'ログインしてください');
    }

    // バリデーション
$validator = Validator::make($request->all(), [
    'date'            => 'required|date',
    'exercise_time'   => 'required|string',
    'exercise_detail' => 'required|string|min:1|max:120',

], [
    'date.required'   => '日付は必須です。',
    'date.date'       => '日付の形式が正しくありません。',
    'exercise_time.required' => '運動時間を入力してください。',
'exercise_detail.required' => '運動内容を入力してください。',
'exercise_detail.min'      => '運動内容は1文字以上で入力してください。',
'exercise_detail.max'      => '運動内容は120文字以内で入力してください。',

]);


    // validate のエラーを配列で取得
    $errors = $validator->errors()->toArray();

    /* -------------------------
       体重チェック
    ------------------------- */
$weight = $request->weight ?? '';

/* 未入力 */
if ($weight === '') {
    $errors['weight'][] = '体重を入力してください。';
    $errors['weight'][] = '小数点以下は1桁で入力してください。';
    $errors['weight'][] = '4桁までの数字で入力してください。';
}

/* 小数点以下1桁チェック（小数点がある場合） */
if (preg_match('/\./', $weight)) {
    if (!preg_match('/^\d{1,4}\.\d{1}$/', $weight)) {
        $errors['weight'][] = '小数点以下は1桁で入力してください。';
    }
}

/* 整数部分だけ取り出す */
$integerPart = explode('.', $weight)[0];

/* 整数部分が数字でない場合（aaaa など） */
if (!preg_match('/^\d+$/', $integerPart)) {
    $errors['weight'][] = '4桁までの数字で入力してください。';
}

/* 整数部分が5桁以上ならエラー */
if (strlen($integerPart) > 4) {
    $errors['weight'][] = '4桁までの数字で入力してください。';
}


    /* -------------------------
       カロリーチェック
    ------------------------- */
    $calories = $request->calories ?? '';

    if ($calories === '') {
        $errors['calories'][] = '摂取カロリーは必須です。';
    }

    if (!preg_match('/^[0-9]+$/', $calories)) {
        $errors['calories'][] = '摂取カロリーは数字のみで入力してください。';
    }

    /* -------------------------
       エラーがあれば返す
    ------------------------- */
    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }

    Record::create([
        'member_id'       => $memberId,
        'date'            => $request->date,
        'weight'          => $request->weight,
        'calories'        => $request->calories,
        'exercise_time'   => $request->exercise_time,
        'exercise_detail' => $request->exercise_detail,
    ]);

    return redirect()->route('mypage');
}

    // ✏️ 編集画面
    public function edit($id)
    {
        $record = Record::findOrFail($id);
        return view('records.edit', compact('record'));
    }

    // 🔄 更新処理
    public function update(Request $request, $id)
    {
        $record = Record::findOrFail($id);

$request->validate([
    'date'            => 'required|date',
    'weight'          => 'required|numeric',
    'calories'        => 'required|integer',
    'exercise_time'   => 'nullable|string',
    'exercise_detail' => 'nullable|string',
], [
    'date.required'   => '日付は必須です。',
    'date.date'       => '日付の形式が正しくありません。',
    'weight.required' => '体重は必須です。',
    'weight.numeric'  => '体重は数値で入力してください。',
    'calories.required' => '摂取カロリーは必須です。',
    'calories.integer'  => '摂取カロリーは整数で入力してください。',
]);



        $record->update([
            'date'            => $request->date,
            'weight'          => $request->weight,
            'calories'        => $request->calories,
            'exercise_time'   => $request->exercise_time,
            'exercise_detail' => $request->exercise_detail,
        ]);

        return redirect()->route('mypage');
    }

public function destroy($id)
{
    $record = Record::findOrFail($id);
    $record->delete();

    return redirect()->route('mypage')->with('success', '削除しました');
}

}


