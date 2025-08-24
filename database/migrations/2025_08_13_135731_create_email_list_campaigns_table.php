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
        Schema::create('email_list_campaigns', function (Blueprint $table) {
            $table->foreignId('email_list_id')
                ->constrained('email_lists')
                ->onDelete('cascade');
            $table->foreignId('email_campaign_id')
                ->constrained('email_campaigns')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_list_campaigns');
    }
};
