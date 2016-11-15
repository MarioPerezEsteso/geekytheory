<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Create 5 images with different sizes assigned to a gallery
        for ($i = 1; $i <= 5; $i++) {
            foreach (\App\Image::SIZES_GALLERY as $size) {
                DB::table('images')->insert([
                    'parent' => $size == \App\Image::SIZE_ORIGINAL ? null : $i * 2 - 1,
                    'user_id' => 1,
                    'post_id' => null,
                    'gallery_id' => 1,
                    'title' => 'whatever',
                    'image' => $i . $size . 'some_image.png',
                    'size' => $size,
                    'order' => $i,
                ]);
            }
        }

    }
}
