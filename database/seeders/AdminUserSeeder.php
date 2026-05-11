<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin par defaut pour la demo
        // email : admin@bienetre.tn
        // mot de passe : admin123
        User::updateOrCreate(
            ['email' => 'admin@bienetre.tn'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
