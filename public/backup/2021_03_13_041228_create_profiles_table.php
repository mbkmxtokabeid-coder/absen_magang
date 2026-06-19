<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('telp_number', 30)->nullable();
            $table->string('phone_number', 30);
            $table->string('whatsapp_number', 30);
            $table->string('school_origin', 100);
            $table->string('major', 50);
            $table->string('semester', 30);
            $table->text('address');
            $table->string('province', 50);
            $table->string('region', 100);
            $table->string('sub_district', 100);
            $table->integer('postal_code')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('website_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
