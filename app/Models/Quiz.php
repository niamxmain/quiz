<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'duration',
        'slug',
        // 'user_id' tidak perlu ada di sini karena sudah diisi otomatis
        // melalui relasi saat kita menggunakan Auth::user()->quizzes()->create().
    ];

    public function questions(): HasMany
{
    return $this->hasMany(Question::class);
}
    public function quizAttempts(): HasMany
{
    return $this->hasMany(QuizAttempt::class);
}
}
