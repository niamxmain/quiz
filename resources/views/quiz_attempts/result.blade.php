<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis: {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-lg p-8 text-center space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-gray-800">Kuis Selesai!</h2>

        <p class="text-lg text-gray-600">Terima kasih telah mengerjakan kuis **{{ $quiz->title }}**.</p>

        <div>
            <p class="text-gray-500">Skor Akhir Anda:</p>
            <p class="text-8xl font-bold text-indigo-600 my-4">{{ $finalScore }}</p>
            <p class="text-gray-700">Anda berhasil menjawab **{{ $score }}** dari **{{ $totalQuestions }}** pertanyaan dengan benar.</p>
        </div>

        <a href="{{ route('quiz.start', $quiz) }}" class="inline-block w-full max-w-xs px-6 py-3 text-lg font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
            Coba Lagi
        </a>
    </div>
</body>
</html>