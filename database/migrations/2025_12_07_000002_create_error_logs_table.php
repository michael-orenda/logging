<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->string('severity');
            $table->text('message')->nullable();
            $table->json('context')->nullable();
            
            // Error specific fields
            $table->longText('stack_trace')->nullable();
            $table->string('source')->default('app');

            $table->timestamps();

            $table->index(['severity', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
