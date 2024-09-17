<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Executa as migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Pendente', 'Em Andamento', 'Concluída'])->default('Pendente');
            $table->enum('priority', ['Baixa', 'Média', 'Alta'])->default('Média');
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
