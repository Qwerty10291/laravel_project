<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("role")->default("user");
            $table->decimal("balance", 8, 2)->after("role")->default(0);
            $table->integer("orders_count")->default(0);
            $table->integer("orders_rating_sum")->default(0);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
};
