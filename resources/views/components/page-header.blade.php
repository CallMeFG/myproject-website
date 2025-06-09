{{-- resources/views/components/page-header.blade.php --}}

@props([
'title',
'backgroundImageUrl',
])

{{-- DIUBAH: Section sekarang berdiri sendiri, tidak lagi di dalam slot --}}
<section class="relative bg-cover bg-center h-40 md:h-48" style="background-image: url('{{ $backgroundImageUrl }}');">
    {{-- Overlay gelap dan efek blur --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    {{-- DIUBAH: Konten sekarang hanya berisi judul di tengah --}}
    <div class="relative z-10 h-full flex justify-center items-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white text-center">
            {{ $title }}
        </h1>
    </div>
</section>