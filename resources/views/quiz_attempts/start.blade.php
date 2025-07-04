{{-- resources/views/quiz_attempts/start.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Kuis: {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script> {{-- Menggunakan CDN Tailwind untuk styling cepat --}}
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800">Selamat Datang di Kuis!</h2>

        <div>
            <h3 class="text-lg font-semibold">{{ $quiz->title }}</h3>
            <p class="mt-2 text-gray-600">{{ $quiz->description }}</p>
            <div class="mt-4 space-y-2">
                <p class="text-sm text-gray-500"><strong>Jumlah Soal:</strong> {{ $quiz->questions->count() }}</p>
                <p class="text-sm text-gray-500"><strong>Durasi:</strong> {{ $quiz->duration }} menit</p>
            </div>
        </div>

        <hr>

        <form method="POST" action="{{ route('quiz.attempt', $quiz) }}">
            @csrf
            <div>
                <label for="student_name" class="block mb-2 text-sm font-medium text-gray-700">Masukkan Nama Anda</label>
                <input type="text" name="student_name" id="student_name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nama Lengkap" required>
            </div>

            <button type="submit" class="w-full px-4 py-2 text-lg font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Mulai Kerjakan
            </button>
        </form>
    </div>
</body>
</html>