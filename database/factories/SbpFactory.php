<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sbp>
 */
class SbpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_sbp' => 'SBP-' . $this->faker->unique()->numberBetween(100, 999),
            'tanggal_sbp' => $this->faker->date(),
            'nomor_surat_perintah' => 'SP-' . $this->faker->unique()->numberBetween(100, 999),
            'tanggal_surat_perintah' => $this->faker->date(),
            'nama_pelaku' => $this->faker->name(),
            'jenis_identitas' => Arr::random(['Paspor', 'KTP', 'SIM']),
            'nomor_identitas' => $this->faker->numerify('##############'),
            'lokasi_penindakan' => $this->faker->address(),
            'waktu_penindakan' => $this->faker->time(),
            'alasan_penindakan' => $this->faker->sentence(),
            'jenis_barang' => $this->faker->word(),
            'jumlah_barang' => $this->faker->numberBetween(1, 100),
            'uraian_barang' => $this->faker->sentence(),
            'nama_petugas_1' => $this->faker->name(),
            'nama_petugas_2' => $this->faker->name(),
        ];
    }
}
