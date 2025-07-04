<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Carbon\Carbon;


class QuizAttemptController extends Controller
{
    public function start(Quiz $quiz)
    {
        return view('quiz_attempts.start', compact('quiz'));
    }

    public function attempt(Request $request, Quiz $quiz)
    {
        // 2. Validasi nama siswa
        $request->validate([
            'student_name' => 'required|string|min:3|max:255',
        ]);

        // 3. Ambil semua ID pertanyaan dan acak urutannya
        $questionIds = $quiz->questions()->inRandomOrder()->pluck('id')->toArray();

        if (empty($questionIds)) {
            return back()->with('error', 'Kuis ini belum memiliki pertanyaan.');
        }

        // 4. Buat catatan percobaan kuis baru
        $attempt = $quiz->quizAttempts()->create([
            'student_name' => $request->student_name,
            'started_at' => now(), // Catat waktu mulai
        ]);

        // 5. Simpan data penting ke dalam session
        $request->session()->put('quiz_attempt', [
            'attempt_id' => $attempt->id,
            'question_ids' => $questionIds,
            'current_question_index' => 0, // Mulai dari soal pertama (index 0)
            'answers' => [], // Siapkan array kosong untuk menyimpan jawaban
        ]);

        // 6. Redirect ke halaman soal pertama
        return redirect()->route('quiz.question', [
            'quiz' => $quiz,
            'question_number' => 1
        ]);
    }

    public function showQuestion(Quiz $quiz, $question_number)
{
    // Ambil data dari session
    $sessionData = session('quiz_attempt');

    // Jika tidak ada session (misal: user langsung ke URL), kembalikan ke awal
    if (!$sessionData) {
        return redirect()->route('quiz.start', $quiz);
    }

    // Ambil ID pertanyaan saat ini
    $questionId = $sessionData['question_ids'][$sessionData['current_question_index']];
    $question = Question::with('options')->find($questionId);

    return view('quiz_attempts.question', compact('quiz', 'question', 'question_number'));
}
}
