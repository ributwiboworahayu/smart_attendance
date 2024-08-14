<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('npp')->unique();
            $table->string('full_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('family_card_number');
            $table->string('identity_number')->unique();
            $table->unsignedBigInteger('religion_id');
            $table->enum('gender', ['L', 'P']);
            $table->string('blood_group');
            $table->unsignedBigInteger('marital_status_id');
            $table->date('marriage_date')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('mobile_phone');
            $table->string('str_number')->nullable()->comment('Surat Tanda Registrasi');
            $table->string('sip_number')->nullable()->comment('Surat Izin Praktek');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->integer('education_id');
            $table->string('institution_name');
            $table->string('major')->comment('Jurusan / Prodi');
            $table->string('graduation_year');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
