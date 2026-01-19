<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Dokumen{{ $sbp->nomor_sbp }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    @include('templatecetak.template-sbp', ['sbp' => $sbp])
    <div class="page-break"></div>
    @include('templatecetak.template-sbp', ['sbp' => $sbp])
    <div class="page-break"></div>
    @include('templatecetak.template-ba-riksa', ['sbp' => $sbp])
    <div class="page-break"></div>
    @include('templatecetak.template-ba-tegah', ['sbp' => $sbp])
    <div class="page-break"></div>
    @include('templatecetak.template-ba-segel', ['sbp' => $sbp])
</body>
</html>
