<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('loan_guarantors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans');
            $table->unsignedBigInteger('affiliate_id');
            $table->foreign('affiliate_id')->references('id')->on('affiliates');
            $table->unsignedBigInteger('affiliate_state_id');
            $table->foreign('affiliate_state_id')->references('id')->on('affiliate_states');
            $table->string('identity_card')->nullable();
            $table->unsignedBigInteger('city_identity_card_id')->nullable();
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->string('registration')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->enum('gender', ['F','M']);
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->unsignedBigInteger('pension_entity_id')->nullable();
            $table->foreign('pension_entity_id')->references('id')->on('pension_entities');
            $table->float('payment_percentage',5,2);// porcentaje de descuento
            $table->float('payable_liquid_calculated',10,2); //promedio liquido pagable calculado individual
            $table->float('bonus_calculated',5,2); //total bonos calculado
            $table->float('quota_previous',5,2); //cuota de refinanciamiento o reprogramación individual
            $table->float('quota_treat',5,2); //cuota pactada del afiliado
            $table->float('indebtedness_calculated',5,2);//indice de endeudamiento calculado individual
            $table->float('indebtedness_calculated_previous',5,2); //indice de endeudamiento calculado previo
            $table->float('liquid_qualification_calculated',10,2); //liquido para calificación calculado individual
            $table->json('contributionable_ids')->nullable(); // ids de las contribuciones si es requerido se definira
            $table->enum('contributionable_type', ['contributions', 'aid_contributions','loan_contribution_adjusts'])->nullable(); // si es requerido se definira
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_guarantors');
    }
}