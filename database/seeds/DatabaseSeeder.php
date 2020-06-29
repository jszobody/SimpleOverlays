<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Theme::create([
            'name' => 'Default',
            'layouts' => '{"lower": "Lower third","half-right": "Half right", "full": "Full screen"}',
            'sizes' => '{"small":"Small","medium":"Medium","large":"Large"}',
            'css' => file_get_contents(base_path('default.css'))
        ]);
    }
}
