<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("products_count")->index();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("name");
            $table->string("description");
            $table->decimal("price", 8, 2);
            $table->integer("rating_count")->default(0);
            $table->integer("rating_sum")->default(0);
            $table->softDeletesDatetime();
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreignId("product_id")->references("id")->on("products")->onDelete("cascade");
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId("seller")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("customer")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });

        Schema::create('chat_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId("chat_id")->references("id")->on("chats")->onDelete("cascade");
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("content");
            $table->timestamp("send_at")->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->references("id")->on("products");
            $table->foreignId("customer_id")->references("id")->on("users");
            $table->foreignId("chat_id")->references("id")->on("users");
            $table->decimal("price");
            $table->string("status")->default("new");
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->references("id")->on("products");
            $table->foreignId("user_id")->references("id")->on("users");
            $table->text("comment");
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->decimal('amount');
            $table->text('payment_system');
            $table->text('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
