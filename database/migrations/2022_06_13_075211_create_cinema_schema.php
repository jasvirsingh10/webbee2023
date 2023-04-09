<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            
            $table->id('user_id')->autoIncrement();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email');
            $table->timestamps();
        });
        
        Schema::create('theatres', function (Blueprint $table) {
            
            $table->id('theatre_id')->autoIncrement();
            $table->string('name')->unique();
            $table->string('city');
            $table->timestamps();
        });
        
        Schema::create('screens', function (Blueprint $table) {
            
            $table->id('screen_id')->autoIncrement();
            $table->foreignId('theatre_id');
            $table->string('name')->unique();
        });
        
        Schema::create('movies', function (Blueprint $table) {
            
            $table->id('movie_id')->autoIncrement();
            $table->string('name')->unique();
            $table->enum('languages', ['English', 'Hindi']);
            $table->timestamps();
        });
        
        Schema::create('shows', function (Blueprint $table) {
            
            $table->id('show_id')->autoIncrement();
            $table->foreignId('movie_id');
            $table->date('date');
            $table->time('time');
        });
        
        Schema::create('screen_shows', function (Blueprint $table) {
            
            $table->id('screen_show_id')->autoIncrement();
            $table->foreignId('screen_id');
            $table->foreignId('show_id');
            $table->enum('booking_status', ['Open', 'Closed']);
        });
        
        Schema::create('fares', function (Blueprint $table) {
            
            $table->id('fare_id')->autoIncrement();
            $table->foreignId('show_id');
            $table->string('class')->unique();
            $table->float('price');
        });
        
        Schema::create('seats', function (Blueprint $table) {
            
            $table->id('seat_id')->autoIncrement();
            $table->foreignId('screen_id');
            $table->foreignId('fare_id');
            $table->string('row');
            $table->integer('number');
            $table->string('status');
        });
        
        Schema::create('reservations', function (Blueprint $table) {
            
            $table->id('reservation_id')->autoIncrement();
            $table->foreignId('user_id');
            $table->foreignId('screen_show_id');
            $table->string('reservation_code');
            $table->string('status');
            $table->timestamps();
        });
        
        Schema::create('reservation_seat_mappers', function (Blueprint $table) {
            
            $table->id('reservation_seat_id')->autoIncrement();
            $table->foreignId('reservation_id');
            $table->foreignId('seat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('theatres');
        Schema::dropIfExists('screens');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('fares');
        Schema::dropIfExists('screen_shows');
        Schema::dropIfExists('seats');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('reservation_seat_mappers');
    }
}
