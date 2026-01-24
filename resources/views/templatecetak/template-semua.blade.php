<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sbp->nomor_sbp }}</title>
    <style>
        body { font-family: 'Arial', Times, serif; font-size: 11pt; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    {{-- 1. Surat Bukti Penindakan --}}
    @include('templatecetak.template-sbp', ['sbp' => $sbp])
    <div class="page-break"></div>

    {{-- 2. Berita Acara Pemeriksaan --}}
    @include('templatecetak.template-ba-riksa', ['sbp' => $sbp])
    <div class="page-break"></div>

    {{-- 3. Berita Acara Penegahan --}}
    @include('templatecetak.template-ba-tegah', ['sbp' => $sbp])
    <div class="page-break"></div>

    {{-- 4. Berita Acara Penyegelan --}}
    @include('templatecetak.template-ba-segel', ['sbp' => $sbp])

    {{-- 5. Berita Acara Serah Terima (jika ada) --}}
    @if ($sbp->bast)
        <div class="page-break"></div>
        @include('templatecetak.template-ba-serah-terima', ['sbp' => $sbp, 'bast' => $sbp->bast])
    @endif
</body>
</html>
