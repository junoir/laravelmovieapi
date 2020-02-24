<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'app_name' => 'StreamApp',
            'authorization' => '', 
            'tmdb_api_key' => 'a95c0a3b234912d28326d5c272124ad1',
            'tmdb_lang' => [
                'english_name' => "English",
                'iso_639_1' => "en",
                'name' => "English"
            ],
            'app_url_android' => '',
            'app_url_ios' => '',
            'title_in_poster' => false,
            'app_bar_animation' => true,
            'livetv' => true,
            'kids' => true,
            'ad_app_id' => 'ca-app-pub-3940256099942544~3347511713',
            'ad_banner' => false,
            'ad_unit_id_banner' => 'ca-app-pub-3940256099942544/6300978111',
            'ad_interstitial' => false, 
            'ad_unit_id_interstitial' => 'ca-app-pub-3940256099942544/1033173712',
            'ad_ios_app_id' => 'ca-app-pub-3940256099942544~1458002511',
            'ad_ios_banner' => false,
            'ad_ios_unit_id_banner' => 'ca-app-pub-3940256099942544/2934735716', 
            'ad_ios_interstitial' => false,
            'ad_ios_unit_id_interstitial' => 'ca-app-pub-3940256099942544/4411468910',      
            'app_color_dark' => true,
            'app_background_color' => '#1C1C1C',
            'app_header_recent_task_color' => '#212121', 
            'app_primary_color' => '#FF4500', 
            'app_splash_color' => '#FF4500', 
            'app_buttons_color' => '#FF4500', 
            'app_bar_color' => '#000000',
            'app_bar_opacity' => 0.15,
            'app_bar_icons_color' => '#FFFFFF', 
            'bottom_navigation_bar_color' => '#1C1C1C',
            'icons_color' => '#FFFFFF',
            'text_color' => '#FFFFFF',
            'app_bar_title_color' => '#FFFFFF'
        ]);
    }
}
