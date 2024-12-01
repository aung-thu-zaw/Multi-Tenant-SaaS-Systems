<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained("users", "id");
            $table->foreignId('tenant_id')->constrained("tenants", "id");
            $table->string("name");
            $table->text("description");
            $table->string("ticket_prefix");
            $table->enum("status", ["active", "on-hold", "completed", "archived"]);
            // $table->enum("priority", ["low","medium", "high", "critical"]);
            $table->timestamps();
        });

        Schema::create('project_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['text', 'date', 'number', 'select', 'checkbox']);
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });

        Schema::create('project_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'admin', 'member'])->default('member');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
