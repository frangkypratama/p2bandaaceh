<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checklist Kelengkapan Berkas Penindakan</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 15mm;
        }
            
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1;
            padding: 0;
            margin: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: middle;
            line-height: 1;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .header-title {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .info-row {
            background-color: #f9f9f9;
        }
        
        .info-label {
            text-align: center;
            font-weight: bold;
            width: 60%;
        }
        
        .info-value {
            text-align: center;
            font-weight: bold;
            width: 40%;
        }
        
        .col-no {
            width: 5%;
            text-align: center;
        }
        
        .col-nama {
            width: 60%;
        }
        
        .col-status {
            width: 20%;
            text-align: center;
        }
        
        .col-ket {
            width: 15%;
            text-align: center;
        }
        
        .row-number {
            text-align: center;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="4" class="header-title">CHECKLIST KELENGKAPAN BERKAS PENINDAKAN</th>
            </tr>
            <tr class="info-row">
                <th colspan="2" class="info-label">NOMOR SURAT BUKTI PENINDAKAN</th>
                <th colspan="2" class="info-value">{{$sbp->nomor_sbp ?? '-' }}</th>
            </tr>
            <tr class="info-row">
                <th colspan="2" class="info-label">TANGGAL SURAT BUKTI PENINDAKAN</th>
                <th colspan="2" class="info-value">{{ optional($sbp->tanggal_sbp)->translatedFormat('d F Y') }}</th>
            </tr>
            <tr>
                <th class="col-no">NO</th>
                <th class="col-nama">NAMA BERKAS</th>
                <th class="col-status">ADA/TIDAK ADA</th>
                <th class="col-ket">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="row-number">1</td>
                <td>SURAT TUGAS (INTELIJEN)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">2</td>
                <td>LAPORAN PELAKSANAAN TUGAS (INTELIJEN)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">3</td>
                <td>LEMBAR PENGUMPULAN DAN PENILAIAN INFORMASI (LPPI)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">4</td>
                <td>LEMBAR KERJA ANALISIS INTELIJEN (LKAI)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">5</td>
                <td>NOTA HASIL INTELIJEN (NHI)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">6</td>
                <td>NOTA INFORMASI (NI)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">7</td>
                <td>LEMBAR INFORMASI (LI-1)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">8</td>
                <td>LEMBAR ANALISIS PRAPENINDAKAN (LAP)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">9</td>
                <td>NOTA PENGEMBALIAN INFORMASI (NPI)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">10</td>
                <td>MEMO PELIMPAHAN PENINDAKAN (MPP)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">11</td>
                <td>SURAT PERINTAH (PENINDAKAN)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">12</td>
                <td>BERITA ACARA PEMERIKSAAN*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">13</td>
                <td>BERITA ACARA PENGAMBILAN CONTOH BARANG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">14</td>
                <td>BERITA ACARA PENEGAHAN*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">15</td>
                <td>BERITA ACARA PENYEGELAN*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">16</td>
                <td>BERITA ACARA PENGAMBILAN DOKUMENTASI</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">17</td>
                <td>BERITA ACARA MEMBAWA SARANA PENGANGKUT DAN/ATAU BARANG</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">18</td>
                <td>SURAT BUKTI PENINDAKAN (SBP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">19</td>
                <td>BERITA ACARA PENOLAKAN TANDA TANGAN SURAT BUKTI PENINDAKAN</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">20</td>
                <td>BERITA ACARA PENOLAKAN TANDA TANGAN TERHADAP BERITA ACARA PENOLAKAN TANDA TANGAN SURAT BUKTI PENINDAKAN</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">21</td>
                <td>PENINDAKAN SEGERA</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">22</td>
                <td>LAPORAN PELAKSANAAN TUGAS (LPT)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">23</td>
                <td>LAPORAN DAN PENENTUAN HASIL PENINDAKAN (LPHP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">24</td>
                <td>LAPORAN PELANGGARAN (LP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">25</td>
                <td>BERITA ACARA SERAH TERIMA (BAST KE PENYIDIKAN)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">26</td>
                <td>LEMBAR PENERIMAAN PERKARA (LPP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">27</td>
                <td>LEMBAR PENELITIAN FORMAL (LPF)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">28</td>
                <td>LAPORAN PELANGGARAN DARI UNIT/INSTANSI LAIN (LP-1)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">29</td>
                <td>SURAT PERINTAH PENELITIAN (SPLIT)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">30</td>
                <td>LEMBAR HASIL PENELITIAN (LHP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">31</td>
                <td>LEMBAR RESUME PERKARA (LRP)*</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">32</td>
                <td>BERITA ACARA PENCACAHAN</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">33</td>
                <td>KEP BDN</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">34</td>
                <td>BERITA ACARA WAWANCARA</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="row-number">35</td>
                <td>Lainnya........................</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>