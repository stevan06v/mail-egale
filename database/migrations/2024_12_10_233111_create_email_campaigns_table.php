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
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('email_configuration_id');
            $table->unsignedBigInteger('email_template_id');
            $table->enum('status', ['draft','scheduled','sending','completed','paused'])->default('draft');
            $table->datetime('schedule_time')->nullable();
            $table->integer('batch_size')->default(50);
            $table->integer('batch_interval')->default(60);
            $table->integer('timeout_per_email')->default(1);
            $table->integer('total_emails')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->string('subject')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('email_blacklist_id')->nullable()->constrained('email_blacklists');
            $table->foreign('email_configuration_id')->references('id')->on('email_configurations')->onDelete('cascade');
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_campaigns');
    }
};
