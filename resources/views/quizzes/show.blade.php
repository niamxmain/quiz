<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- BLOK UNTUK MENAMPILKAN PESAN --}}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-2">Deskripsi Kuis</h3>
                    <p class="mb-4">{{ $quiz->description ?: 'Tidak ada deskripsi.' }}</p>
                    <p class="text-sm text-gray-600">Durasi: {{ $quiz->duration }} menit</p>
                    <hr class="my-6">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Daftar Pertanyaan</h3>
                        <a href="{{ route('questions.create', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Pertanyaan
                        </a>
                    </div>

                    {{-- Tampilkan daftar pertanyaan --}}
                    <div class="mt-6 space-y-6">
                        @forelse ($questions as $question)
                            <div class="p-4 border rounded-lg">
                                <div class="flex justify-between items-start">
                                    <p class="font-semibold">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                                    {{-- Tombol Aksi untuk Soal --}}
                                    <div class="flex space-x-2 flex-shrink-0 ml-4">
                                        <a href="{{ route('questions.edit', $question) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
                                        <form action="{{ route('questions.destroy', $question) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Pilihan Jawaban --}}
                                <ul class="mt-4 space-y-2 list-disc list-inside">
                                    @foreach ($question->options as $option)
                                        <li class="{{ $option->is_correct ? 'text-green-600 font-bold' : '' }}">
                                            {{ $option->option_text }}
                                            @if ($option->is_correct)
                                                <span class="text-green-600">(Jawaban Benar)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">
                                Belum ada pertanyaan untuk kuis ini.
                            </p>
                        @endforelse
                    </div>

                    {{-- Link untuk Pagination --}}
                    <div class="mt-6">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    const alertElement = document.getElementById('success-alert') || document.getElementById('error-alert');
    if (alertElement) {
        setTimeout(() => {
            alertElement.style.transition = 'opacity 0.5s ease';
            alertElement.style.opacity = '0';
            setTimeout(() => alertElement.style.display = 'none', 500);
        }, 3000);
    }
</script>

</x-app-layout>