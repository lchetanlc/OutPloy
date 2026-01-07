<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('website_checks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('website_id')->constrained()->cascadeOnDelete();
        $table->string('status'); 
        $table->unsignedSmallInteger('http_code')->nullable();
        $table->unsignedInteger('response_ms')->nullable();
        $table->text('error')->nullable();
        $table->timestamp('checked_at');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('website_checks');
    }
};
