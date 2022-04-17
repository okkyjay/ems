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
        Schema::create('message_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("chat_employee_id")
                ->nullable()
                ->references('id')
                ->on("employees")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("message_id")
                ->nullable()
                ->references('id')
                ->on("messages")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->longText("message");
            $table->string("is_read")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_conversations');
    }
};
