<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// RUTE UNTUK GURU (MEMBUTUHKAN LOGIN)
Route::middleware('auth')->group(function () {
    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Kuis
    Route::resource('quizzes', QuizController::class);
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');

    // Rute Pertanyaan (Nested)
    Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

// RUTE UNTUK SISWA (PUBLIK)
Route::get('/attempt/{quiz:slug}', [QuizAttemptController::class, 'start'])->name('quiz.start');
Route::post('/attempt/{quiz:slug}', [QuizAttemptController::class, 'attempt'])->name('quiz.attempt');
Route::get('/attempt/{quiz:slug}/question/{question_number}', [QuizAttemptController::class, 'showQuestion'])->name('quiz.question');
Route::post('/attempt/{quiz:slug}/question/{question_number}', [QuizAttemptController::class, 'storeAnswer'])->name('quiz.answer.store');
Route::get('/attempt/{quiz:slug}/result', [QuizAttemptController::class, 'showResult'])->name('quiz.result');

require __DIR__.'/auth.php';