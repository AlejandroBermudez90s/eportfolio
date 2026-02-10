<?php

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
    Schema::create('modulos_formativos', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('ciclo_formativo_id');
            $table->foreign('ciclo_formativo_id')->references('id')->on('ciclos_formativos');

        $table->string('nombre')->nullable();
        $table->string('codigo')->unique()->nullable();

        $table->integer('horas_totales')->nullable();
        $table->string('curso_escolar')->nullable();
        $table->string('centro')->nullable()->require();

        $table->unsignedBigInteger('docente_id')->nullable();
            $table->foreign('docente_id')->references('id')->on('users');

        $table->text('descripcion')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_formativos');
    }
};
