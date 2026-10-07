<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@portofarch.com')],
            ['name' => 'POA Admin', 'password' => env('ADMIN_PASSWORD') ?: Str::password(16)],
        );

        $this->call(SiteSeeder::class);
    }
}
