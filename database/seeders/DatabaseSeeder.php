<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'first_name' => 'John',
        //     'middle_name' => 'Bd.',
        //     'last_name' => 'Doe',
        //     'email' => 'john@example.com',
        //     'password' => bcrypt('admin123')
        // ]);

        // developer
        \App\Models\Admin::factory(1)->create([
            'name'  => 'Developer',
            'email' => 'dev@code.com',
            'role'  => 'developer',
        ]);

        // admin
        \App\Models\Admin::factory(1)->create([
            'name'  => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);

        $this->runArtisanClearCommands();
        
    }


    private function runArtisanClearCommands(): void
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
    }
}
