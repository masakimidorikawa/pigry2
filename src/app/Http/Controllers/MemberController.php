<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Models\Record;
use App\Models\WeightLog;



class MemberController extends Controller
{
    // STEP1 表示
    public function create()
    {
        return view('members.create');
    }

    // STEP1 保存
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:members,email',
            'password' => 'required|min:6',
        ], [
            'name.required'     => '名前を入力してください。',
            'email.required'    => 'メールアドレスを入力してください。',
            'email.email'       => '正しいメールアドレス形式で入力してください。',
            'email.max'         => 'メールアドレスは255文字以内で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min'      => 'パスワードは6文字以上で入力してください。',
        ]);

    // DB に保存（★ ここで $member を受け取る）
    $member = Member::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // ★ 登録後に自動ログイン（これが必要）
    session(['member_id' => $member->id]);

        // STEP2 へ進む
        return redirect()->route('register.step2');
    }

    // STEP2 表示
    public function step2()
    {
        return view('members.step2');
    }

    // STEP2 保存
public function step2Store(Request $request)
{
    $errors = [];

    // ▼ 現在の体重
$cw = $request->current_weight ?? '';

// a. 未入力
if ($cw === '') {
    $errors['current_weight'][] = '現在の体重を入力してください。';
    $errors['current_weight'][] = '小数点以下は1桁で入力してください。';
    $errors['current_weight'][] = '4桁までの数字で入力してください。';
}


// b. 数値じゃない
if (!empty($cw) && !preg_match('/^[0-9.]+$/', $cw)) {
    $errors['current_weight'][] = '数字で入力してください。';
}

// c. 4桁以内じゃない
if (!empty($cw) && preg_match('/^[0-9.]+$/', $cw) && !preg_match('/^\d{1,4}(\.\d+)?$/', $cw)) {
    $errors['current_weight'][] = '現在の体重は4桁以内で入力してください。';
}

// d. 小数点1桁じゃない（小数点なし or 2桁以上）
if (!empty($cw) && preg_match('/^[0-9.]+$/', $cw) && !preg_match('/^\d{1,4}\.\d{1}$/', $cw)) {
    $errors['current_weight'][] = '現在の体重は小数点1桁で入力してください。';
}



    // ▼ 目標の体重
$tw = $request->target_weight ?? '';


// a. 未入力

if ($tw === '') {
    $errors['target_weight'][] = '目標の体重を入力してください。';
    $errors['target_weight'][] = '小数点以下は1桁で入力してください。';
    $errors['target_weight'][] = '4桁までの数字で入力してください。';
}

// b. 数値じゃない
if (!empty($tw) && !preg_match('/^[0-9.]+$/', $tw)) {
    $errors['target_weight'][] = '数字で入力してください。';
}

// c. 4桁以内じゃない
if (!empty($tw) && preg_match('/^[0-9.]+$/', $tw) && !preg_match('/^\d{1,4}(\.\d+)?$/', $tw)) {
    $errors['target_weight'][] = '目標の体重は4桁以内で入力してください。';
}

// d. 小数点1桁じゃない
if (!empty($tw) && preg_match('/^[0-9.]+$/', $tw) && !preg_match('/^\d{1,4}\.\d{1}$/', $tw)) {
    $errors['target_weight'][] = '目標の体重は小数点1桁で入力してください。';
}


    // ▼ エラーが1つでもあればまとめて返す
    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }
$memberId = session('member_id');
$member = Member::find($memberId);

if (!$member) {
    return back()->withErrors(['member' => 'ログイン情報が見つかりません。']);
}

$member->current_weight = $cw;
$member->target_weight = $tw;
$member->save();

return redirect()->route('mypage');



}
public function loginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    // バリデーション
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'メールアドレスを入力してください。',
        'email.email' => '正しいメールアドレス形式で入力してください。',
        'password.required' => 'パスワードを入力してください。',
    ]);

    // ユーザーを検索
    $member = Member::where('email', $request->email)->first();

    if (!$member) {
        return back()->withErrors(['email' => 'メールアドレスが登録されていません。'])->withInput();
    }

    // パスワードチェック
    if (!Hash::check($request->password, $member->password)) {
        return back()->withErrors(['password' => 'パスワードが正しくありません。'])->withInput();
    }

    // ログイン成功 → セッションに保存
    session(['member_id' => $member->id]);

    return redirect()->route('mypage'); // ← ログイン後の画面
}

public function mypage(Request $request)
{
    // ログイン中のユーザーIDを取得
    $memberId = session('member_id');

    // ユーザー情報
    $member = Member::find($memberId);

    // ▼ 記録一覧（検索付き）
    $query = Record::where('member_id', $memberId);

    if ($request->from) {
        $query->whereDate('date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('date', '<=', $request->to);
    }

    $records = $query->orderBy('date', 'desc')
                     ->paginate(8)
                     ->appends($request->all());




    // 目標体重
    $target_weight = $member->target_weight;

    // 最新体重（記録があれば記録の最新、なければSTEP2の現在体重）
    $latest_weight = $records->first()->weight ?? $member->current_weight;

    // 目標まで
    $to_goal = ($latest_weight !== null && $target_weight !== null)
        ? $target_weight - $latest_weight
        : null;

    return view('members.mypage', compact(
        'target_weight',
        'latest_weight',
        'to_goal',
        'records' // ← Blade と一致
    ));
}


public function logout(Request $request)
{
    // セッションを完全に破棄
    $request->session()->flush();

    // ログイン画面へ
    return redirect()->route('login');
}


public function editTarget()
{
    $memberId = session('member_id');
    $member = Member::find($memberId);

    return view('members.edit_target', [
        'target_weight' => $member->target_weight
    ]);
}
public function updateTarget(Request $request)
{
$tw = $request->target_weight;

// 数値チェック
if (!preg_match('/^[0-9.]+$/', $tw)) {
    $errors['target_weight'][] = '数字で入力してください。';
}

// 4桁以内チェック
if (!preg_match('/^\d{1,4}(\.\d+)?$/', $tw)) {
    $errors['target_weight'][] = '4桁以内で入力してください。';
}

// 小数点1桁チェック
if (!preg_match('/^\d{1,4}\.\d{1}$/', $tw)) {
    $errors['target_weight'][] = '小数点は1桁で入力してください。';
}

// エラーがあれば返す
if (!empty($errors)) {
    return back()->withErrors($errors)->withInput();
}

    // ▼ 保存処理（これがないとマイページに反映されない）
    $memberId = session('member_id');
    $member = Member::find($memberId);

    if ($member) {
        $member->target_weight = $tw;
        $member->save();
    }

    return redirect()->route('mypage');
}




}