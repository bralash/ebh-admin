<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requested_by');
            $table->string('requester_phone', 10);
            $table->integer('requester_location_id')->unsigned();
            $table->integer('blood_type_id')->unsigned();
            $table->boolean('by_donor')->default(0);
            $table->timestamp('notification_sent_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('requester_location_id')->references('id')->on('communities')->onDelete('restrict');
            $table->foreign('blood_type_id')->references('id')->on('blood_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blood_requests');
    }
}
