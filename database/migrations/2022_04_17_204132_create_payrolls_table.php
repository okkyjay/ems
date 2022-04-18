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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")
                ->nullable()
                ->references('id')
                ->on("employees")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->string("basic_salary");
            $table->string("tax_deduction");
            $table->string("net_salary");
            $table->string("month");
            $table->string("year");
            $table->string("status")->default(1);
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
        Schema::dropIfExists('payrolls');
    }
};
