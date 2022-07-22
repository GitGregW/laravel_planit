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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('body');
            $table->string('address_line_1', 100);
            $table->string('address_line_2', 100);
            $table->string('address_city', 100);
            $table->string('address_county', 100);
            $table->string('postcode', 10);
            $table->string('contact_mobile', 20);
            $table->string('contact_landline', 20);
            $table->decimal('rating', 5, 1);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
