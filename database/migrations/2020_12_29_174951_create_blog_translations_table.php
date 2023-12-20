<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('blog_id')->unsigned();
            $table->string('locale')->index();
            $table->string('blog_title');
            $table->text('description');
            $table->text('blog_slug');

            $table->unique(['blog_id', 'locale']);
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('blog_title');
            $table->dropColumn('blog_slug');
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_translations');
    }
}
