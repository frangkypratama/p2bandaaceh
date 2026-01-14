<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    /**
     * Menampilkan daftar semua tabel di database.
     */
    public function database()
    {
        $tables = Schema::getTables();
        
        // Untuk SQLite, getTables() mengembalikan array of arrays.
        // Kita perlu mengekstrak nilai dari key 'name'.
        $tableNames = array_map(function($table) {
            return $table['name'];
        }, $tables);

        return view('database.database', ['tables' => $tableNames]);
    }

    /**
     * Menampilkan isi dari tabel yang dipilih.
     */
    public function showTable($tableName)
    {
        // Validasi untuk memastikan tabel ada untuk keamanan
        if (!Schema::hasTable($tableName)) {
            abort(404, "Tabel tidak ditemukan.");
        }

        $columns = Schema::getColumnListing($tableName);
        $data = DB::table($tableName)->paginate(15); // Paginasi 15 baris per halaman

        return view('database.show', [
            'tableName' => $tableName,
            'columns' => $columns,
            'data' => $data,
        ]);
    }
}
