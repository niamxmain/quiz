<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
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
        // 3. Validasi data yang masuk
        $request->validate([
            'question_text' => 'required|string|min:3',
            'options' => 'required|array|min:4', // Pastikan ada 4 opsi
            'options.*' => 'required|string|min:1', // Setiap opsi harus diisi
            'correct_option' => 'required|integer|between:0,3', // Pastikan radio button dipilih
        ]);

        // 4. Mulai Database Transaction
        DB::beginTransaction();
        try {
            // 5. Simpan Pertanyaan
            $question = $quiz->questions()->create([
                'question_text' => $request->question_text,
            ]);

            // 6. Simpan Pilihan Jawaban
            foreach ($request->options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($index == $request->correct_option),
                ]);
            }

            // 7. Jika semua berhasil, konfirmasi transaksi
            DB::commit();

        } catch (Throwable $e) {
            // 8. Jika ada error, batalkan semua yang sudah disimpan
            DB::rollBack();
            // Optional: catat error atau tampilkan pesan error yang lebih spesifik
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pertanyaan.');
        }

        // 9. Redirect kembali ke halaman detail kuis dengan pesan sukses
        return redirect()->route('quizzes.show', $quiz)->with('success', 'Pertanyaan berhasil ditambahkan!');
    }
}
