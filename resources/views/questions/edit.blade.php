<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pertanyaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('questions.update', $question) }}">
                        @csrf
                        @method('PUT')

                        {{-- BLOK UNTUK MENAMPILKAN ERROR --}}
                        @if ($errors->any())
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
                                <span class="font-medium">Terdapat kesalahan:</span>
                                <ul class="mt-1.5 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="question_text" :value="__('Teks Pertanyaan')" />
                            <textarea id="question_text" name="question_text" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h3 class="text-lg font-medium mb-2">Pilihan Jawaban</h3>
                        <div class="space-y-4">
                            @foreach($question->options as $index => $option)
                            <div class="flex items-center space-x-4">
                                <div class="flex-grow">
                                    <x-input-label for="options_{{ $option->id }}" :value="__('Opsi ' . ($index + 1))" />
                                    <input type="hidden" name="option_ids[]" value="{{ $option->id }}">
                                    <x-text-input id="options_{{ $option->id }}" class="block mt-1 w-full" type="text" name="options[]" :value="old('options.'.$index, $option->option_text)" required />
                                </div>
                                <div class="flex flex-col items-center pt-5">
                                    <x-input-label for="correct_option" :value="__('Benar?')" />
                                    <input type="radio" name="correct_option" value="{{ $option->id }}" class="mt-2" {{ old('correct_option', $option->is_correct ? $option->id : '') == $option->id ? 'checked' : '' }} required>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('quizzes.show', $question->quiz_id) }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md">Batal</a>
                            <x-primary-button class="ml-4">{{ __('Update Pertanyaan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>