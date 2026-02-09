<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
     {
        Schema::create('ciclos_formativos', function (Blueprint $table) {
            $table->id();
            $table -> string('familia_profesional_id')->nullable();
            $table -> string('nombre', 255)->nullable();
            $table -> string('codigo', 50)->nullable()->unique();
            $table->enum('grado', ['medio', 'superior', 'basica', 'C.E. (superior)', 'C.E. (medio)']);
            $table -> text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ciclos_formativos');
    }
};
