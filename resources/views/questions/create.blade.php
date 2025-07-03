<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pertanyaan Baru untuk Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('questions.store', $quiz) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="question_text" :value="__('Teks Pertanyaan')" />
                            <textarea id="question_text" name="question_text" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('question_text') }}</textarea>
                            <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                        </div>

                        <hr class="my-4">

                        <h3 class="text-lg font-medium mb-2">Pilihan Jawaban</h3>
                        <div class="space-y-4">
                            @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center space-x-4">
                                <div class="flex-grow">
                                    <x-input-label for="options.{{ $i }}" :value="__('Opsi ' . ($i + 1))" />
                                    <x-text-input id="options.{{ $i }}" class="block mt-1 w-full" type="text" name="options[]" :value="old('options.'.$i)" required />
                                </div>
                                <div class="flex flex-col items-center pt-5">
                                    <x-input-label for="correct_option" :value="__('Benar?')" />
                                    <input type="radio" name="correct_option" value="{{ $i }}" class="mt-2" required>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('options.'.$i)" class="mt-2" />
                            @endfor
                            <x-input-error :messages="$errors->get('correct_option')" class="mt-2" />
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md">
                                Batal
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Pertanyaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>