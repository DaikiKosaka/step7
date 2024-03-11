<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
            $table->string('product_name');
            $table->integer('price');
            $table->integer('stock');
            $table->text('comment')->nullable();
            $table->string('img_path', 255)->nullable();
            $table->unsignedBigInteger('company_id'); // company_id列を追加
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies'); // 外部キー制約を設定
        });
    }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['company_id']); // 外部キー制約を削除
            $table->dropColumn('company_id'); // company_id列を削除
        });
    }
}
