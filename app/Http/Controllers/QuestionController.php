<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string|min:3',
            'options' => 'required|array|min:4',
            'options.*' => 'required|string|min:1',
            'correct_option' => 'required|integer|between:0,3',
        ]);

        DB::beginTransaction();
        try {
            $question = $quiz->questions()->create([
                'question_text' => $request->question_text,
            ]);

            foreach ($request->options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($index == $request->correct_option),
                ]);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pertanyaan: ' . $e->getMessage());
        }

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit(Question $question)
    {
        $question->load('options');
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|min:3',
            'options' => 'required|array|min:4',
            'options.*' => 'required|string|min:1',
            'option_ids' => 'required|array|min:4',
            'correct_option' => 'required|integer|exists:options,id',
        ]);

        DB::beginTransaction();
        try {
            $question->update([
                'question_text' => $request->question_text,
            ]);

            foreach ($request->option_ids as $index => $option_id) {
                $option = Option::find($option_id);
                if ($option) {
                    $option->update([
                        'option_text' => $request->options[$index],
                        'is_correct' => ($option_id == $request->correct_option),
                    ]);
                }
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pertanyaan: ' . $e->getMessage());
        }

        return redirect()->route('quizzes.show', $question->quiz_id)->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        $quizId = $question->quiz_id;
        $question->delete();
        return redirect()->route('quizzes.show', $quizId)->with('success', 'Pertanyaan berhasil dihapus!');
    }
}