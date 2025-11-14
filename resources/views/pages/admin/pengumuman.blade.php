@extends('layouts.adminLayout')

@section('title', 'Pengumuman | SIPANDAKABULAN')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-megaphone text-white text-lg"></i>
                    </div>
                    Pengumuman
                </h2>
                <p class="text-gray-600 mt-2">Kelola pengumuman untuk desa</p>
            </div>

            <a href="{{ route('admin.pengumuman.create') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                <i class="bi bi-plus-circle"></i>
                Tambah Pengumuman
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg flex items-center gap-3">
            <i class="bi bi-check-circle text-2xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap w-16">No</th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">Judul & Isi</th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">Dibuat</th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">Target Desa</th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($pengumumans as $i => $item)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="py-4 px-6 text-gray-600 font-medium">
                                {{ $pengumumans->firstItem() + $i }}
                            </td>

                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 mb-1">
                                    {{ $item->judul }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit(strip_tags($item->isi), 80) }}
                                </div>
                                @if ($item->file)
                                    <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $item->file }}"
                                        target="_blank"
                                        class="text-blue-600 hover:text-blue-800 text-xs flex items-center gap-1 mt-1">
                                        <i class="bi bi-paperclip"></i>
                                        Lihat File
                                    </a>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-gray-600 text-sm">
                                {{ $item->created_at->format('d M Y') }}
                                <br>
                                <span class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    <i class="bi bi-building"></i>
                                    {{ is_array($item->desa_ids) ? count($item->desa_ids) : 0 }} Desa
                                </span>
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                                        class="w-9 h-9 bg-yellow-500 text-white rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-all duration-200"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button onclick="deletePengumuman({{ $item->id }})"
                                        class="w-9 h-9 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition-all duration-200"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="bi bi-inbox text-gray-400 text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada pengumuman</p>
                                    <p class="text-gray-400 text-sm mt-1">Buat pengumuman pertama Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pengumumans->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deletePengumuman(id) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
