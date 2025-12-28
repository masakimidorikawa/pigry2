<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;

class WeightLogController extends Controller
{
    // 編集画面
    public function edit($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);
        return view('weight_logs.edit', compact('weightLog'));
    }

    // 更新処理
    public function update(Request $request, $weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);

        $weightLog->update([
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('mypage')->with('success', '更新しました');
    }

    // 削除処理
    public function destroy($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);
        $weightLog->delete();

        return redirect()->route('mypage')->with('success', '削除しました');
    }
}