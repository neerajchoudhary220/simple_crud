<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            ['name' => 'Pizza'],
            ['name' => 'Burger'],
            ['name' => 'Salad'],
            ['name' => 'Fries'],
            ['name' => 'Pasta'],
        ];
        foreach($data as $food){
            Food::updateOrCreate($food);
        }
    }
}
