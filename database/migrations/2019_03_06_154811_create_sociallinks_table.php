<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociallinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sociallinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facebook',255);
            $table->string('googleplus',255);
            $table->string('instagram',255);
            $table->string('pinterest',255);
            $table->string('youtube',255);
            $table->string('linkedin',255);
            $table->string('twitter',255);
            $table->string('snapdeal',255);
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
        Schema::dropIfExists('sociallinks');
    }
}
