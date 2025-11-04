<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Belirtilen email adresine sahip kullanıcıyı super admin yapar';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Email adresi sor
        $email = $this->ask('Email adresini giriniz:');

        if (empty($email)) {
            $this->error('Email adresi boş olamaz!');
            return self::FAILURE;
        }

        // Email formatını kontrol et
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Geçersiz email formatı!');
            return self::FAILURE;
        }

        // Kullanıcıyı bul
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Email adresi '{$email}' ile kayıtlı kullanıcı bulunamadı!");
            return self::FAILURE;
        }

        // Super admin rolünü kontrol et veya oluştur
        $role = Role::firstOrCreate(['name' => 'super_admin'], [
            'guard_name' => 'web',
        ]);

        // Kullanıcı zaten super admin mi kontrol et
        if ($user->hasRole('super_admin')) {
            $this->warn("Kullanıcı '{$user->name}' ({$user->email}) zaten super admin!");
            return self::SUCCESS;
        }

        // Super admin rolünü ata
        $user->assignRole('super_admin');

        $this->info("✓ Kullanıcı '{$user->name}' ({$user->email}) başarıyla super admin yapıldı!");
        
        return self::SUCCESS;
    }
}

