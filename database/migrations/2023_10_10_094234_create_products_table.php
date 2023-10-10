<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('UNIQUE_KEY')->unique();
            $table->longText('PRODUCT_TITLE');
            $table->longText('PRODUCT_DESCRIPTION');
            $table->longText('STYLE#');
            $table->longText('AVAILABLE_SIZES');
            $table->longText('BRAND_LOGO_IMAGE');
            $table->longText('THUMBNAIL_IMAGE');
            $table->longText('COLOR_SWATCH_IMAGE');
            $table->longText('PRODUCT_IMAGE');
            $table->longText('SPEC_SHEET');
            $table->longText('PRICE_TEXT');
            $table->longText('SUGGESTED_PRICE');
            $table->longText('CATEGORY_NAME');
            $table->longText('SUBCATEGORY_NAME');
            $table->longText('COLOR_NAME');
            $table->longText('COLOR_SQUARE_IMAGE');
            $table->longText('COLOR_PRODUCT_IMAGE');
            $table->longText('COLOR_PRODUCT_IMAGE_THUMBNAIL');
            $table->longText('SIZE');
            $table->longText('QTY');
            $table->longText('PIECE_WEIGHT');
            $table->longText('PIECE_PRICE');
            $table->longText('DOZENS_PRICE');
            $table->longText('CASE_PRICE');
            $table->longText('PRICE_GROUP');
            $table->longText('CASE_SIZE');
            $table->longText('INVENTORY_KEY');
            $table->longText('SIZE_INDEX');
            $table->longText('SANMAR_MAINFRAME_COLOR');
            $table->longText('MILL');
            $table->longText('PRODUCT_STATUS');
            $table->longText('COMPANION_STYLES');
            $table->longText('MSRP');
            $table->longText('MAP_PRICING');
            $table->longText('FRONT_MODEL_IMAGE_URL');
            $table->longText('BACK_MODEL_IMAGE');
            $table->longText('FRONT_FLAT_IMAGE');
            $table->longText('BACK_FLAT_IMAGE');
            $table->longText('PRODUCT_MEASUREMENTS');
            $table->longText('PMS_COLOR');
            $table->longText('GTIN');


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
