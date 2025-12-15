{{-- resources/views/components/upload-kategori-dinamis.blade.php --}}
@props(['indikator', 'kategoris'])

<div x-data="uploadManager()" class="space-y-4">
    {{-- Kategori Default (dari seeder) --}}
    @foreach($kategoris->where('is_custom', false) as $kategori)
        <div class="border rounded-lg p-4 bg-gray-50">
            <label class="block font-medium text-gray-700 mb-2">
                {{ $kategori->nama_kategori }}
            </label>
            
            {{-- Multiple File Upload --}}
            <div x-data="{ files: [] }" class="space-y-2">
                <input 
                    type="file" 
                    name="file_{{ $kategori->id }}[]"
                    multiple
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    @change="files = Array.from($event.target.files)"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100"
                >
                
                {{-- Preview files --}}
                <template x-if="files.length > 0">
                    <div class="mt-2 space-y-1">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="text-xs text-gray-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                </svg>
                                <span x-text="file.name"></span>
                                <span class="text-gray-400">(<span x-text="(file.size / 1024).toFixed(2)"></span> KB)</span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Show existing files --}}
            @php
                $existingFiles = $kategori->berkasUploads()
                    ->whereHas('penilaian', function($q) use ($indikator) {
                        $q->where('indikator_id', $indikator->id)
                          ->where('bulan', now()->format('F'))
                          ->where('tahun', now()->year);
                    })->get();
            @endphp
            
            @if($existingFiles->count() > 0)
                <div class="mt-3 space-y-1">
                    <p class="text-xs font-medium text-gray-600">File yang sudah diupload:</p>
                    @foreach($existingFiles as $berkas)
                        <div class="flex items-center justify-between text-xs bg-white px-2 py-1 rounded">
                            <span class="text-blue-600">{{ basename($berkas->path_file) }}</span>
                            <a href="{{ route('berkas.download', $berkas->id) }}" 
                               class="text-green-600 hover:text-green-800">
                                Download
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    {{-- Kategori Custom (user-defined) --}}
    <template x-for="(kategori, index) in customKategoris" :key="index">
        <div class="border rounded-lg p-4 bg-yellow-50 relative">
            <button 
                @click="removeCustomKategori(index)"
                type="button"
                class="absolute top-2 right-2 text-red-500 hover:text-red-700"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kategori
                </label>
                <input 
                    type="text"
                    x-model="kategori.nama"
                    placeholder="Contoh: SK Tambahan XYZ"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Upload File
                </label>
                <input 
                    type="file"
                    @change="kategori.file = $event.target.files[0]"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-yellow-50 file:text-yellow-700
                        hover:file:bg-yellow-100"
                    required
                >
            </div>
        </div>
    </template>

    {{-- Tombol Tambah Kategori --}}
    <button 
        @click="addCustomKategori()"
        type="button"
        class="w-full py-3 px-4 border-2 border-dashed border-gray-300 rounded-lg
               text-gray-600 hover:border-blue-500 hover:text-blue-600
               transition-colors duration-200 flex items-center justify-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span class="font-medium">Tambah Kategori Upload Baru</span>
    </button>
</div>

<script>
function uploadManager() {
    return {
        customKategoris: [],
        
        addCustomKategori() {
            this.customKategoris.push({
                nama: '',
                file: null,
            });
        },
        
        removeCustomKategori(index) {
            if (confirm('Hapus kategori ini?')) {
                this.customKategoris.splice(index, 1);
            }
        },
    }
}
</script>