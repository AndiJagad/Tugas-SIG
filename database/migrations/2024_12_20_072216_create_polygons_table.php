<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up() 
{ 
    Schema::create('polygons', function (Blueprint $table) { 
        $table->id(); 
        $table->text('coordinates'); // JSON string of coordinates 
        $table->timestamps(); 
    }); 
} 
};
