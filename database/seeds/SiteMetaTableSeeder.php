<?php

use Illuminate\Database\Seeder;

class SiteMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_meta')->insert([
            'title'             => 'Site title',
            'subtitle'          => 'Site subtitle',
            'description'       => 'Site description',
            'url'               => 'http://laraweb.com',
            'image'             => 'site-image.png',
            'logo'              => 'site-logo.png',
            'favicon'           => 'site-favicon.png',
            'logo_57'           => 'site-logo-57.png',
            'logo_72'           => 'site-logo-72.png',
            'logo_114'          => 'site-logo-114.png',
            'twitter'           => 'http://link-to-social-network.com',
            'instagram'         => 'http://link-to-social-network.com',
            'facebook'          => 'http://link-to-social-network.com',
            'github'            => 'http://link-to-social-network.com',
            'youtube'           => 'http://link-to-social-network.com',
            'dribbble'          => 'http://link-to-social-network.com',
            'google-plus'       => 'http://link-to-social-network.com',
            'stack-overflow'    => 'http://link-to-social-network.com',
            'flickr'            => 'http://link-to-social-network.com',
            'bitbucket'         => 'http://link-to-social-network.com',
            'linkedin'          => 'http://link-to-social-network.com',
            'menu'              => '[{"text":"Home","link":"http://domain.com","submenu":null}]',
        ]);
    }
}
