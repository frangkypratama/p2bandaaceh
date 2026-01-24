<?php

namespace App\Helpers;

class TerbilangHelper
{
    protected static $angka = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
    ];

    public static function terbilang($n)
    {
        if ($n < 12) {
            return trim(static::$angka[$n]);
        }
        if ($n < 20) {
            return trim(static::terbilang($n - 10) . ' belas');
        }
        if ($n < 100) {
            return trim(static::terbilang($n / 10) . ' puluh ' . static::terbilang($n % 10));
        }
        if ($n < 200) {
            return trim('seratus ' . static::terbilang($n - 100));
        }
        if ($n < 1000) {
            return trim(static::terbilang($n / 100) . ' ratus ' . static::terbilang($n % 100));
        }
        if ($n < 2000) {
            return trim('seribu ' . static::terbilang($n - 1000));
        }
        if ($n < 1000000) {
            return trim(static::terbilang($n / 1000) . ' ribu ' . static::terbilang($n % 1000));
        }
        if ($n < 1000000000) {
            return trim(static::terbilang($n / 1000000) . ' juta ' . static::terbilang($n % 1000000));
        }
        // Lanjutkan untuk miliar, triliun, dst. jika perlu
        return '';
    }

    public static function ucfirst($string)
    {
        if ($string === null || $string === '') {
            return '';
        }
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }

    public static function tanggal($date)
    {
        $carbonDate = \Carbon\Carbon::parse($date);
        
        $hari = static::terbilang($carbonDate->day);
        
        $namaBulan = $carbonDate->getTranslatedMonthName('id');

        $tahun = static::terbilang($carbonDate->year);

        return static::ucfirst($hari) . ' ' . static::ucfirst($namaBulan) . ' ' . static::ucfirst($tahun);
    }
}
