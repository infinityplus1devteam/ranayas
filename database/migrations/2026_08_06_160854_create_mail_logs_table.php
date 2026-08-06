<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('from_name');
            $table->string('from_email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('form_source');                    // e.g. "Enquiry Popup", "Sell with Us Popup", "Contact Page"
            $table->enum('status', ['success', 'failed']);
            $table->text('error_message')->nullable();        // Full exception/error detail on failure
            $table->string('error_code')->nullable();         // PHPMailer error code or HTTP code
            $table->string('ip_address', 45)->nullable();     // IPv4 / IPv6
            $table->string('user_agent')->nullable();         // Browser/bot user agent
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_logs');
    }
};
