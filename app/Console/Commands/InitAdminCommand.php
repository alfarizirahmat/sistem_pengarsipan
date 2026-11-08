<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class InitAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun pengurus RT utama jika belum tersedia di database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Pengurus RT 005',
                'email' => 'rt@bumimutiara.id',
                'password' => Hash::make('password'),
                'role' => 'ketua_rt',
                'jabatan' => 'Ketua RT 005',
                'phone' => '081234567890',
            ]);

            $this->info('Akun pengurus RT berhasil dibuat: rt@bumimutiara.id / password');
        } else {
            $this->info('Akun pengurus sudah ada. Tidak ada perubahan.');
        }

        return self::SUCCESS;
    }
}
