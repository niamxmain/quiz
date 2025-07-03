{{-- resources/views/quizzes/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
    @if (session('success'))
        <div id="success-alert" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="error-alert" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100">
            {{ session('error') }}
        </div>
    @endif
</div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-2">Deskripsi Kuis</h3>
                    <p class="mb-4">{{ $quiz->description ?: 'Tidak ada deskripsi.' }}</p>
                    <p class="text-sm text-gray-600">Durasi: {{ $quiz->duration }} menit</p>
                    <hr class="my-6">

                    {{-- Tombol Aksi dan Daftar Soal --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Daftar Pertanyaan</h3>
                        <a href="{{ route('questions.create', $quiz) }}" class="inline-flex ...">
    Tambah Pertanyaan
</a>
                    </div>

                    {{-- Di sini nanti kita tampilkan tabel daftar soal --}}
                    <p class="text-center text-gray-500 py-4">
                        Belum ada pertanyaan untuk kuis ini.
                    </p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Cari elemen alert berdasarkan ID yang kita buat
    const successAlert = document.getElementById('success-alert');

    // Jika elemen tersebut ada di halaman
    if (successAlert) {
        // Atur waktu (dalam milidetik) sebelum alert hilang
        // 3000ms = 3 detik
        setTimeout(() => {
            // Mulai transisi fade-out
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';

            // Setelah transisi selesai, sembunyikan elemen sepenuhnya
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 500); // 500ms cocok dengan durasi transisi
        }, 3000);
    }
</script>