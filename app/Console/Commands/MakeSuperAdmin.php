<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
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

        // Super admin rolünü ata (eğer yoksa)
        if (!$user->hasRole('super_admin')) {
            $user->assignRole('super_admin');
        }

        // Tüm izinleri super admin rolüne ata (her zaman güncelle)
        $this->info('Tüm izinler super admin rolüne atanıyor...');
        $this->syncAllPermissions($role);

        $this->info("✓ Kullanıcı '{$user->name}' ({$user->email}) super admin yetkileri güncellendi!");
        
        return self::SUCCESS;
    }

    /**
     * Tüm izinleri super admin rolüne senkronize et
     */
    protected function syncAllPermissions(Role $role): void
    {
        $allPermissions = Permission::where('guard_name', 'web')->get();
        
        if ($allPermissions->isEmpty()) {
            $this->warn('Henüz hiç izin tanımlanmamış. İzinleri oluşturmak için: php artisan shield:generate --all');
            return;
        }

        $permissionCount = $allPermissions->count();
        $role->syncPermissions($allPermissions);
        
        $this->info("✓ {$permissionCount} adet izin super admin rolüne atandı.");
    }
}

