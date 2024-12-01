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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->constrained("projects","id");
            $table->foreignId("assigned_to")->constrained("users","id");
            $table->string("title");
            $table->text("description");
            // $table->enum("priority", ["low","medium", "high", "urgent"]);
            $table->enum("status",["pending","in-progress","completed","blocked"]);
            $table->foreignId('status_id')->nullable()->constrained('project_statuses')->onDelete('set null');  // Status per task
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
