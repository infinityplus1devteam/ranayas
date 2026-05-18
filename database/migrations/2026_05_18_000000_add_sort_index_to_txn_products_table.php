<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortIndexToTxnProductsTable extends Migration
{
    public function up()
    {
        Schema::table('txn_products', function (Blueprint $table) {
            $table->integer('sort_index')->nullable()->after('slug_url');
        });
    }

    public function down()
    {
        Schema::table('txn_products', function (Blueprint $table) {
            $table->dropColumn('sort_index');
        });
    }
}
