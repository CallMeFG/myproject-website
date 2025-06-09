<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kamar: ') }} {{ $room->type }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Metode HTTP untuk update adalah PUT atau PATCH --}}

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Kamar</label>
                            <input type="text" name="type" id="type" value="{{ old('type', $room->type) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm" required autofocus>
                            @error('type')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga per Malam (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $room->price) }}" placeholder="Contoh: 500000"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm" required>
                            @error('price')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Gambar Kamar (Opsional)</label>
                            {{-- Tampilkan gambar saat ini jika ada --}}
                            @if ($room->image)
                            <div class="mt-2 mb-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Gambar saat ini:</p>
                                <img src="{{ $room->image_url }}" alt="Gambar {{ $room->type }}" class="mt-1 w-48 h-auto rounded shadow-md">
                            </div>
                            @else
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Belum ada gambar untuk kamar ini.</p>
                            @endif

                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="image_help">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="image_help">
                                Format: JPG, PNG, JPEG. Maks: 6MB. Kosongkan jika tidak ingin mengganti gambar.
                            </p>
                            @error('image')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kuantitas</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $room->quantity) }}" min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm" required>
                            @error('quantity')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update Kamar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>