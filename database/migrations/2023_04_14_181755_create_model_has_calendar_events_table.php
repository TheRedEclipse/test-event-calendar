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
        Schema::create('model_has_calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_event_id')->nullable()->constrained('calendar_events')->onDelete('cascade');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_calendar_events');
    }
};
