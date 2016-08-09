<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('categories')->insert([
                'category' => "Category $i",
                'slug' => "category-$i",
                'image' => 'some_image.png',
            ]);
        }
    }
}
