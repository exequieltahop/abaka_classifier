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
        Schema::create('inferenced_images', function (Blueprint $table) {
            $table->id();
            $table->longText('image_path');
            $table->longText('img_file_name');
            $table->unsignedInteger('status')->default(1);
            $table->string('system_predicted_class');
            $table->decimal('class_probability');
            $table->unsignedInteger('expert_validation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inferenced_images');
    }
};
