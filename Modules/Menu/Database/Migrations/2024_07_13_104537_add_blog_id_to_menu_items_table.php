<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlogIdToMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('blog_id')->unsigned()->nullable()->after('category_id');

            $table->foreign('blog_id')->references('id')->on('post_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign(['blog_id']);
            $table->dropColumn('blog_id');
        });
    }
}
;