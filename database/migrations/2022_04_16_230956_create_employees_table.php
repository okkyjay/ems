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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('employee_number')->unique();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('access_code')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->foreignId("department_id")
                ->nullable()
                ->references('id')
                ->on("departments")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("bank_id")
                ->nullable()
                ->references('id')
                ->on("banks")
                ->onDelete("restrict")
                ->onUpdate("restrict");

            $table->foreignId("designation_id")
                ->nullable()
                ->references('id')
                ->on("designations")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("state_id")
                ->nullable()
                ->references('id')
                ->on("states")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("country_id")
                ->nullable()
                ->references('id')
                ->on("countries")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->string('status')->nullable();
            $table->longText('bio')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_hired')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
