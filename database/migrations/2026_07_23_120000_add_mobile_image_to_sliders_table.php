<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('mobile_image')->nullable()->after('image_url');
            $table->string('button_text')->nullable()->after('url');
            $table->string('content_position')->nullable()->default('center-left')->after('button_text');
            $table->string('text_align')->nullable()->default('left')->after('content_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['mobile_image', 'button_text', 'content_position', 'text_align']);
        });
    }
};
