<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ganti kolom string 'role' (admin/user) di users dengan relasi 'role_id'
     * ke tabel roles yang baru, supaya role bisa dikelola dinamis lewat Role Management.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('nip')->constrained()->nullOnDelete();
        });

        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        if (! $adminRoleId) {
            $adminRoleId = DB::table('roles')->insertGetId([
                'name' => 'admin',
                'label' => 'Admin',
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');
        if (! $userRoleId) {
            $userRoleId = DB::table('roles')->insertGetId([
                'name' => 'user',
                'label' => 'User',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('users')->where('role', 'admin')->update(['role_id' => $adminRoleId]);
        DB::table('users')->where('role', '<>', 'admin')->orWhereNull('role')->update(['role_id' => $userRoleId]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('user')->after('nip');
        });

        DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->update(['users.role' => DB::raw('roles.name')]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
        });
    }
};
