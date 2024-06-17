<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price');
        $table->date('expiration_date');
        $table->binary('image')->nullable(); // Coluna para armazenar a imagem diretamente no banco de dados
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Adicione esta linha dentro do método up() da migração products
        $table->timestamps();
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
