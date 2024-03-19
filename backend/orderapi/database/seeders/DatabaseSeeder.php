<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderActivity;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(CausalSeeder::class);
        $this->call(ObservationSeeder::class);
        $this->call(TypeActivitySeeder::class);

        //se crea un usuario con rol administrador
        User::factory()->create([
            'role_id' => 1
        ]);

        //se crean varios usuarios con rol supervisor
        User::factory(3)->create([
            'role_id' => 2
        ]);

        Technician::factory()->create([
            'especiality' => 'Instalación de redes'
        ]);
        
        Technician::factory(2)->create([
            'especiality' => 'Construcción'
        ]);

        Technician::factory(2)->create([
            'especiality' => 'Lectura de redes'
        ]);
        
        //técnico sin especialidad
        Technician::factory(2)->create();

        $this->call(ActivitySeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderActivitySeeder::class);
        
    }
}
