<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('app_name');
            $table->String('authorization')->nullable();
            $table->String('tmdb_api_key')->nullable();
            $table->longText('tmdb_lang');
            $table->boolean('aws_s3_storage')->default(0);
            $table->String('aws_access_key_id')->nullable();
            $table->String('aws_secret_access_key')->nullable();
            $table->String('aws_default_region')->nullable();
            $table->String('aws_bucket')->nullable();
            $table->String('app_url_android')->nullable();
            $table->String('app_url_ios')->nullable();
            $table->boolean('title_in_poster'); 
            $table->boolean('app_bar_animation'); 
            $table->boolean('livetv'); 
            $table->boolean('kids'); 
            $table->String('ad_app_id')->nullable(); 
            $table->boolean('ad_banner');
            $table->String('ad_unit_id_banner')->nullable();
            $table->boolean('ad_interstitial'); 
            $table->String('ad_unit_id_interstitial')->nullable(); 
            $table->String('ad_ios_app_id')->nullable(); 
            $table->boolean('ad_ios_banner'); 
            $table->String('ad_ios_unit_id_banner')->nullable(); 
            $table->boolean('ad_ios_interstitial'); 
            $table->String('ad_ios_unit_id_interstitial')->nullable();         
            $table->boolean('app_color_dark');
            $table->String('app_background_color');
            $table->String('app_header_recent_task_color'); 
            $table->String('app_primary_color'); 
            $table->String('app_splash_color'); 
            $table->String('app_buttons_color'); 
            $table->String('app_bar_color');
            $table->float('app_bar_opacity')->unsigned()->max(1);
            $table->String('app_bar_icons_color'); 
            $table->String('bottom_navigation_bar_color');
            $table->String('icons_color');
            $table->String('text_color');
            $table->String('app_bar_title_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
