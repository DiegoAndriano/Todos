<?php

namespace Database\Seeders;

use App\Models\SubTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubTag::create([
            'name' => 'Test',
            'tag_id' => '1'
        ]);

        SubTag::create([
            'name' => 'Code',
            'tag_id' => '1'
        ]);

        SubTag::create([
            'name' => 'Research',
            'tag_id' => '1'
        ]);

        SubTag::create([
            'name' => 'Test',
            'tag_id' => '2'
        ]);

        SubTag::create([
            'name' => 'Code',
            'tag_id' => '2'
        ]);

        SubTag::create([
            'name' => 'Research',
            'tag_id' => '2'
        ]);

        SubTag::create([
            'name' => 'Bicicleta',
            'tag_id' => '3'
        ]);

        SubTag::create([
            'name' => 'Crossfit',
            'tag_id' => '3'
        ]);
    }
}
