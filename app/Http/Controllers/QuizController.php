<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz; // Ensure you have the Quiz model imported
use Illuminate\Support\Facades\Auth; // Import Auth facade if needed
use Illuminate\Support\Str; // Import Str facade for slug generation

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::where('user_id', Auth::id())
                       ->latest()
                       ->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer|min:1',
    ]);

    // 2. Buat slug dari judul
    $validatedData['slug'] = Str::slug($validatedData['title']);

    // 3. Simpan data ke database melalui relasi
    $request->user()->quizzes()->create($validatedData);

    // 4. Redirect ke halaman daftar kuis dengan pesan sukses
    return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
