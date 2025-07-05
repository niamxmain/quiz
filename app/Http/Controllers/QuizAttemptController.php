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
    // Validasi nama siswa
    $request->validate([
        'student_name' => 'required|string|min:3|max:255',
    ]);

    // Ambil semua ID pertanyaan dan acak urutannya
    $questionIds = $quiz->questions()->inRandomOrder()->pluck('id')->toArray();

    if (empty($questionIds)) {
        return back()->with('error', 'Kuis ini belum memiliki pertanyaan.');
    }

    // Buat catatan percobaan kuis baru
    $attempt = $quiz->quizAttempts()->create([
        'student_name' => $request->student_name,
        'started_at' => now(), // Catat waktu mulai
    ]);

    // Simpan semua data penting ke dalam session (INI BAGIAN YANG DIPERBAIKI)
    $request->session()->put('quiz_attempt', [
        'attempt_id'             => $attempt->id,
        'started_at'             => $attempt->started_at->toIso8601String(), // Waktu mulai
        'question_ids'           => $questionIds,                           // Daftar ID soal
        'current_question_index' => 0,                                     // Index soal saat ini
        'answers'                => [],                                      // Jawaban yang sudah diisi
    ]);

    // Redirect ke halaman soal pertama
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


public function storeAnswer(Request $request, Quiz $quiz, $question_number)
{
    // 1. Validasi bahwa siswa memilih salah satu opsi
    $request->validate([
        'option_id' => 'required|integer|exists:options,id'
    ]);

    // 2. Ambil data dari session
    $sessionData = $request->session()->get('quiz_attempt');

    // 3. Simpan jawaban siswa
    // Kita simpan ID pertanyaan dan ID jawaban yang dipilih
    $currentQuestionId = $sessionData['question_ids'][$sessionData['current_question_index']];
    $sessionData['answers'][$currentQuestionId] = (int)$request->option_id;

    // 4. Pindah ke soal berikutnya
    $sessionData['current_question_index']++;

    // 5. Simpan kembali data ke session
    $request->session()->put('quiz_attempt', $sessionData);

    // 6. Cek apakah kuis sudah selesai
    if ($sessionData['current_question_index'] >= count($sessionData['question_ids'])) {
        // Jika sudah selesai, arahkan ke halaman hasil (akan kita buat nanti)
        return redirect()->route('quiz.result', $quiz);
    } else {
        // Jika belum, arahkan ke soal selanjutnya
        return redirect()->route('quiz.question', [
            'quiz' => $quiz,
            'question_number' => $sessionData['current_question_index'] + 1
        ]);
    }
}

public function showResult(Quiz $quiz)
{
    // Logika untuk menghitung skor akan kita tambahkan di sini nanti
    dd(session('quiz_attempt')); // 'dd' adalah "dump and die", untuk melihat isi session
}
}
