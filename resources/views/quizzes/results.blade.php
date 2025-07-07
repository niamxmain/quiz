<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil untuk Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Skor</th>
                                    <th scope="col" class="px-6 py-3">Waktu Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attempts as $attempt)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $attempt->student_name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-lg {{ $attempt->score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $attempt->score }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Format tanggal agar mudah dibaca --}}
                                        @if ($attempt->finished_at)
    {{ $attempt->finished_at->translatedFormat('d F Y, H:i') }}
@else
    <span class="text-gray-400">Belum Selesai</span>
@endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada yang mengerjakan kuis ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $attempts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>