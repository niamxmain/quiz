<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('quizzes', QuizController::class);

    Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
});

Route::get('/attempt/{quiz:slug}', [QuizAttemptController::class, 'start'])->name('quiz.start');
Route::post('/attempt/{quiz:slug}', [QuizAttemptController::class, 'attempt'])->name('quiz.attempt');
Route::get('/attempt/{quiz:slug}/question/{question_number}', [QuizAttemptController::class, 'showQuestion'])->name('quiz.question');
Route::post('/attempt/{quiz:slug}/question/{question_number}', [QuizAttemptController::class, 'storeAnswer'])->name('quiz.answer.store');
Route::get('/attempt/{quiz:slug}/result', [QuizAttemptController::class, 'showResult'])->name('quiz.result');

require __DIR__.'/auth.php';
