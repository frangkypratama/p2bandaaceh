<?php

namespace App\Exports;

use App\Models\Sbp;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class SbpExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $search;
    protected $startDate;
    protected $endDate;

    public function __construct($search, $startDate, $endDate)
    {
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = Sbp::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nomor_sbp', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pelaku', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_identitas', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_identitas', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_barang', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_sbp', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('tanggal_sbp', 'desc')->orderBy('nomor_sbp_int', 'desc');
    }

    public function headings(): array
    {
        return [
            'Nomor SBP',
            'Tanggal SBP',
            'Nomor Surat Perintah',
            'Tanggal Surat Perintah',
            'Nama Pelaku',
            'Jenis Identitas',
            'Nomor Identitas',
            'No. HP',
            'Jenis Kelamin',
            'Alamat di Indonesia',
            'Lokasi Penindakan',
            'Kota Penindakan',
            'Kecamatan Penindakan',
            'Waktu Penindakan',
            'Jenis Barang',
            'Jumlah Barang',
            'Jenis Satuan',
            'Uraian Barang',
            'Kondisi Barang',
            'Nama Petugas 1',
            'Nama Petugas 2',
            'Nomor BA Riksa',
            'Nomor BA Tegah',
            'Nomor BA Segel',
            'Nomor BA Musnah',
            'Alasan Penindakan',
        ];
    }

    public function map($sbp): array
    {
        return [
            $sbp->nomor_sbp,
            optional($sbp->tanggal_sbp)->format('d-m-Y'),
            $sbp->nomor_surat_perintah,
            optional($sbp->tanggal_surat_perintah)->format('d-m-Y'),
            $sbp->nama_pelaku,
            $sbp->jenis_identitas,
            $sbp->nomor_identitas,
            $sbp->no_hp,
            $sbp->jenis_kelamin,
            $sbp->alamat_di_indonesia,
            $sbp->lokasi_penindakan,
            $sbp->kota_penindakan,
            $sbp->kecamatan_penindakan,
            $sbp->waktu_penindakan,
            $sbp->jenis_barang,
            $sbp->jumlah_barang,
            $sbp->jenis_satuan,
            $sbp->uraian_barang,
            $sbp->kondisi_barang,
            $sbp->nama_petugas_1,
            $sbp->nama_petugas_2,
            $sbp->nomor_ba_riksa,
            $sbp->nomor_ba_tegah,
            $sbp->nomor_ba_segel,
            $sbp->nomor_ba_musnah,
            $sbp->alasan_penindakan,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Kolom G = Nomor Identitas, Kolom H = No HP
                // Set format kolom ke Text dulu
                $sheet->getStyle('G:G')
                    ->getNumberFormat()
                    ->setFormatCode('@');

                $sheet->getStyle('H:H')
                    ->getNumberFormat()
                    ->setFormatCode('@');

                // Lalu paksa setiap cell jadi string explicit
                for ($i = 2; $i <= $highestRow; $i++) {
                    // Nomor Identitas (kolom G)
                    $valG = $sheet->getCell("G{$i}")->getValue();
                    if ($valG !== null && $valG !== '') {
                        $sheet->getCell("G{$i}")->setValueExplicit(
                            trim((string) $valG),
                            DataType::TYPE_STRING
                        );
                    }

                    // No HP (kolom H)
                    $valH = $sheet->getCell("H{$i}")->getValue();
                    if ($valH !== null && $valH !== '') {
                        $sheet->getCell("H{$i}")->setValueExplicit(
                            trim((string) $valH),
                            DataType::TYPE_STRING
                        );
                    }
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}