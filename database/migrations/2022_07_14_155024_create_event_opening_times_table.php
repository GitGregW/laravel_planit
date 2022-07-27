<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_opening_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('day', 100)->nullable();
            $table->time('opening_time');
            $table->time('closing_time');
            $table->date('custom_date')->nullable();
            $table->boolean('custom_repeat_yearly')->nullable();
            $table->integer('max_capacity')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'day'], 'unique_event_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_opening_times');
    }
};
