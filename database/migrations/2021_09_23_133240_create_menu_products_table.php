<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('menu_categories')->onDelete("cascade");
            $table->text('name_ar');
            $table->text('name_en');
            $table->text('desc_ar');
            $table->text('desc_en');
            $table->integer('price');
            $table->boolean('isNew')->default(0);
            $table->boolean('isSpecial')->default(0);
            $table->text('options')->nullable();
            $table->text('additions')->nullable();
            $table->text('group_id')->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media');
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
        Schema::dropIfExists('menu_products');
    }
}
