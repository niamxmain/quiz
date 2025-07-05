<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal {{ $question_number }} - {{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 md:p-8">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">{{ $quiz->title }}</h2>
                <div class="text-lg font-semibold text-red-500">
                    Sisa Waktu: <span id="timer">--:--</span>
                </div>
            </div>
            <p class="text-gray-600 mb-6">Pertanyaan {{ $question_number }} dari {{ count(session('quiz_attempt.question_ids')) }}</p>

            <div class="border-t pt-6">
                <p class="text-lg font-semibold mb-4">{{ $question->question_text }}</p>

                <form action="{{ route('quiz.answer.store', ['quiz' => $quiz, 'question_number' => $question_number]) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        @foreach ($question->options->shuffle() as $option)
                            <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="option_id" value="{{ $option->id }}" class="h-5 w-5 text-indigo-600">
                                <span class="ml-4 text-gray-700">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-8 text-right">
                        <button type="submit" class="px-8 py-3 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 font-semibold">
                            Selanjutnya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    // Ambil waktu selesai dari session (dibuat saat attempt dimulai)
    const quizDuration = {{ $quiz->duration }}; // dalam menit
    const attemptStartedAt = '{{ session("quiz_attempt.started_at", now()) }}';

    const endTime = new Date(attemptStartedAt).getTime() + quizDuration * 60 * 1000;

    const timerElement = document.getElementById('timer');
    const quizForm = document.querySelector('form');

    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = endTime - now;

        // Perhitungan waktu
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilkan di elemen timer
        timerElement.textContent = String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');

        // Jika waktu habis
        if (distance < 0) {
            clearInterval(countdown);
            timerElement.textContent = "WAKTU HABIS";
            // Otomatis submit form
            quizForm.submit();
        }
    }, 1000);
</script>
</html>