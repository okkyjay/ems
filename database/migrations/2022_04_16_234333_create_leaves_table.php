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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(0);
            $table->date('leave_from');
            $table->date('leave_to');
            $table->longText('employee_remark')->nullable();
            $table->longText('admin_remark')->nullable();
            $table->foreignId("leave_type_id")
                ->nullable()
                ->references('id')
                ->on("leave_types")
                ->onDelete("restrict")
                ->onUpdate("restrict");
            $table->foreignId("employee_id")
                ->nullable()
                ->references('id')
                ->on("employees")
                ->onDelete("restrict")
                ->onUpdate("restrict");
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
        Schema::dropIfExists('leaves');
    }
};
