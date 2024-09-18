<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('part_number');
            $table->string('definition');
            $table->integer('qty');
            $table->date('date');
            $table->foreignId('biomed_id'); // Assuming 'users' table has the requesters
            $table->string('department'); // Replace department_id with normal string field
            $table->text('reason')->nullable();
            $table->string('work_order_number')->nullable();
            $table->integer('left_in_stock');
            $table->enum('status', ['pending', 'under_processing', 'canceled', 'approved', 'done'])->default('pending');
            $table->foreignId('qty_id')->nullable(); // Add qty_id column with a foreign key constraint

            $table->timestamps();

            // Indexes or additional constraints
            $table->foreign('biomed_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('qty_id')->references('id')->on('items')->onDelete('set null'); // Define foreign key for qty_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
