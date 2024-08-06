<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubordinateTrainingTable extends Migration
{
    public function up()
    {
        Schema::create('subordinate_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subordinate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // Example statuses: pending, completed, in-progress
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subordinate_training');
    }
}
