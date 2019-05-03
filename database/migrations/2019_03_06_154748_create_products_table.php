<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('featured_image')->default('');
            $table->float('price')->nullable()->default(0);
            $table->float('strike_price')->nullable()->default(0);
            $table->string('snapdeal')->default('');
            $table->string('flipkart')->default('');
            $table->string('amazon')->default('');
            $table->tinyInteger('availability');
            $table->text('description')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('products');
    }
}
