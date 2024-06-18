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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('_token')->nullable();
            $table->integer('status')->default(1);
            $table->foreignId('strand_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignId('section_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->string('grade_level')->nullable();
            $table->string('school_id')->unique()->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->date('birthdate');
            $table->string('gender');                               // select from datalist
            $table->integer('civil_status')->nullable();                        // enum
            $table->string('contact_number')->nullable();
            $table->string('religion')->nullable();                 // might select from datalist (not strict)
            $table->string('facebook_url')->nullable();

            /**
             * Address
             */
            $table->string('purok')->nullable();
            $table->string('sitio_street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->integer('zip_code')->nullable();
            $table->integer('status_type')->default(1);

            $table->string('guardian_name')->nullable();        //parent or guardian name;

            $table->string('profile_image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
