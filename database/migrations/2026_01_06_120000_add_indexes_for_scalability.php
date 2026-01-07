<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        
        Schema::table('websites', function (Blueprint $table) {
            $table->index('client_id');
            $table->index(['client_id', 'last_status']);
        });

        
        Schema::table('website_checks', function (Blueprint $table) {
            $table->index('website_id');
            $table->index('created_at');
            $table->index(['website_id', 'status']);
        });
    }

    
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
            $table->dropIndex(['client_id', 'last_status']);
        });

        Schema::table('website_checks', function (Blueprint $table) {
            $table->dropIndex(['website_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['website_id', 'status']);
        });
    }
};
