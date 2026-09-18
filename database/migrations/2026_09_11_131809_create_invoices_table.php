<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('order_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->decimal('subtotal', 10, 2);                      
            $table->decimal('discount_amount', 10, 2)->default(0);   
            $table->decimal('tax_rate', 5, 2)->default(0);           
            $table->decimal('tax_amount', 10, 2)->default(0);       
            $table->decimal('total_amount', 10, 2);                  
            $table->string('tax_number')->nullable();                
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
