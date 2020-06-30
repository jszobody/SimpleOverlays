<?php

use App\Regex;
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
            'layouts' => ["lower" => "Lower third", "half-right" => "Half right", "full" => "Full screen"],
            'sizes' => ["small" => "Small","medium" => "Medium","large"=>"Large"],
            'default_layout' => 'lower',
            'default_size' => 'medium',
            'css' => file_get_contents(base_path('stubs/default.css'))
        ]);

        $transformation = \App\Transformation::create([
            'name' => 'LSB Special Characters'
        ]);

        $transformation->regexes()->saveMany(
            [
                new Regex(["find" => "/P\t/", "replace" => "<span style='font-family: LSBSymbol'>P\t</span>"]),
                new Regex(["find" => "/C\t(.*)/", "replace" => "<span style='font-family: LSBSymbol'>C\t</span><strong>$1</strong>"]),
                new Regex(["find" => "/\sT\s/", "replace" => "<span style='font-family: LSBSymbol'> T </span>"]),
            ]
        );
    }
}
