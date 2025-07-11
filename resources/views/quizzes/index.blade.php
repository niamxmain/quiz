<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kuis Saya') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" id="success-alert" role="alert">
            {{ session('success') }}
        </div>
    @endif
`</div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4">
                        Buat Kuis Baru
                    </a>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul Kuis</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Soal</th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($quizzes as $quiz)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
    <a href="{{ route('quizzes.show', $quiz) }}" class="hover:underline">
        {{ $quiz->title }}
    </a>
</th>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quiz->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($quiz->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $quiz->questions_count }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('quizzes.results', $quiz) }}" class="font-medium text-blue-600 hover:underline">Hasil</a>
                                        <a href="{{ route('quizzes.edit', $quiz) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
<form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="font-medium text-red-600 hover:underline ml-4" onclick="return confirm('Apakah Anda yakin ingin menghapus kuis ini?')">
        Hapus
    </button>
</form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Anda belum memiliki kuis.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $quizzes->links() }}
                    </div>

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