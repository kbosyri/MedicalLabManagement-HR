<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employeeschedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class,'role_id')->nullable();
            $table->enum('main_role',['admin','lab_staff','reception'])->nullable();
            $table->string('days_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeschedules');
    }
};
