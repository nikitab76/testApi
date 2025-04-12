<?php

namespace Database\Seeders;

use App\Models\Partnership;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnership = Partnership::create(['name' => 'ООО Логистика']);

        User::factory()->create([
            'name' => 'Manager 1',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'partnership_id' => $partnership->id,
        ]);

        Worker::factory()->count(10)->create();
    }
}
