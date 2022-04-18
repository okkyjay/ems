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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_one_id")
                ->nullable()
                ->references('id')
                ->on("employees")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("employee_two_id")
                ->nullable()
                ->references('id')
                ->on("employees")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->string("time");
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
        Schema::dropIfExists('messages');
    }
};
