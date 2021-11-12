<template>
  <v-container fluid>
    <v-row
      justify="center"
      v-show="modalidad.procedure_type_name != 'Préstamo Hipotecario'"
    >
      <!-- Vista cuando el prestamo no tiene garantes-->
      <v-col cols="12" class="py-0" v-if="modalidad_guarantors == 0">
        <v-card>
          <v-container class="py-0">
            <v-col class="text-center">
              <h2 class="success--text">ESTA MODALIDAD NO NECESITA GARANTE</h2>
            </v-col>
          </v-container>
        </v-card>
      </v-col>
      <!--Vista cuando el prestamo tiene garantes-->
      <template v-else>
        <!-- Detalle del garante cuando es rehacer una modalidad con garante-->
        <v-col cols="12" v-if="modalidad_guarantors > 0" v-show="remake">
          <v-card>
            <v-container class="py-0">
              <v-col class="text-center">
                <h5>Informacion Garantes</h5>
              </v-col>
              <ul style="list-style: none" class="pa-0">
                <li v-for="(garantes_detalle_loan,i) in data_loan_parent_aux.guarantors" :key="i" >
                  <v-progress-linear></v-progress-linear>
                    <v-row>
                    <v-col cols="12" md="5" class="py-0">
                      Nombre del Afiliado: {{garantes_detalle_loan.first_name +' '+ garantes_detalle_loan.last_name }}
                    </v-col>
                    <v-col cols="12" md="2" class="py-0">
                      C.I.: {{garantes_detalle_loan.identity_card}}
                    </v-col>
                      <v-col cols="12" md="2" class="py-0">
                      Sigep: {{garantes_detalle_loan.sigep_status}}
                    </v-col>
                      <v-col cols="12" md="3" class="py-0">
                      Porcentaje de Pago: {{garantes_detalle_loan.pivot.payment_percentage}}
                    </v-col>
                  </v-row>
                  </li>
              </ul>
            </v-container>
          </v-card>
        </v-col>
        <v-col cols="12" md="4" class="py-0">
          <!-- Panel del buscador-->
          <v-card>
            <v-container class="py-0">
              <v-row>
                <v-col cols="12" md="8" class="px-5 pt-3">
                  <v-text-field
                    label="C.I. o Matricula"
                    v-model="guarantor_ci"
                    class="py-0"
                    single-line
                    hide-details
                    clearable
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-tooltip>
                    <template v-slot:activator="{ on }">
                      <v-btn fab dark x-small v-on="on" color="info"
                      @click.stop="searchGuarantor()">
                        <v-icon>mdi-magnify</v-icon>
                      </v-btn>
                    </template>
                  </v-tooltip>
                </v-col>
              <template v-if="existence_garantor.double_perception">
                <v-col cols="12" md="11" class="success--text pb-0 ma-0 py-0" >
                  <h6 class="caption">
                    Afiliado de doble percepcion, escoger como evaluar.
                  </h6>
                </v-col>
                <v-col cols="12" md="5" class="pb-0 ma-0 py-0">
                  <v-radio-group
                    class="pb-0 ma-0 py-0"
                    v-model="type_affiliate"
                    row
                  >
                    <v-radio
                      label="Titular"
                      :value="false"
                      class="pb-0 ma-0 py-0"
                      @change="searchGuarantor()"
                    ></v-radio>
                    <v-radio
                      label="conyuge"
                      :value="true"
                      class="pb-0 ma-0 py-0"
                      @change="searchGuarantor()"
                    ></v-radio>
                  </v-radio-group>
                </v-col>
              </template>
                <!--<v-col cols="12" md="5" class="pb-0 ma-0 py-0">
                  <center>
                    <v-btn class="py-0 text-right" color="info" rounded x-small
                      >Evaluar
                    </v-btn>
                  </center>
                </v-col>-->
              </v-row>
            </v-container>
          </v-card>
        </v-col>

        <v-col cols="12" md="8" class="py-0" v-if="modalidad_guarantors>0">
          <v-card v-show="!show_garante">
            <v-container>
              <v-row>
                <v-col class="text-center" cols="12" md="12">
                  <h4 class="error--text">
                    CANTIDAD DE GARANTES QUE NECESITA ESTA MODALIDAD:{{
                      modalidad_guarantors
                    }}<br />
                    EL GARANTE DEBE ESTAR ENTRE UNA CATEGORIA DE {{loan_detail.min_guarantor_category * 100}}% A {{loan_detail.max_guarantor_category * 100}}% 
                  </h4>
                </v-col>
              </v-row>
            </v-container>
          </v-card>

          <v-card v-show="show_garante">
            <v-col cols="12" md="12"  class="py-0" >
              <h3 class="red--text text-center " v-show="!affiliate_guarantor.guarantor">NO PUEDE SER GARANTE:
                <h6>{{affiliate_guarantor.message}}</h6>
              </h3>
              <h3 class="success--text text-center" v-show="affiliate_guarantor.guarantor"> PUEDE SER GARANTE
                <h6 v-show="affiliate_guarantor.information_missing != ''">Información faltante: {{affiliate_guarantor.information_missing}}</h6>
              </h3>
           <!--selectedGuaranteedLoans<pre>{{selectedGuaranteedLoans}}</pre>
           contribution<pre>{{contribution}}</pre>
            guarantor_detail<pre>{{guarantor_detail}}</pre>
            guarantors<pre>{{guarantors}}</pre>-->
           </v-col>

            <v-progress-linear></v-progress-linear>
            <v-col cols="12" md="12" class="font-weight-black caption ma-0 py-0">
            <v-row>
            <v-col cols="12" md="12" class="font-weight-black caption ma-0 py-0">
              DATOS DEL AFILIADO
            </v-col>
            <v-col cols="12" md="12" class="ma-0 py-0 font-weight-light caption">
              AFILIADO : {{$options.filters.fullName(affiliate_guarantor.affiliate, true)}}
            </v-col>
            <v-col cols="12" md="4" class="ma-0 py-0 font-weight-light caption">
              C.I : {{affiliate_guarantor.affiliate.identity_card}}
            </v-col>
            <v-col cols="12" md="4" class="ma-0 py-0 font-weight-light caption">
              CATEGORIA: {{affiliate_guarantor.affiliate.category_name}}
            </v-col>
            <v-col cols="12" md="4" class="py-0 font-weight-light caption">
              MATRICULA: {{affiliate_guarantor.affiliate.registration}}
            </v-col>
            <v-col
              cols="12"
              md="4"
              class="text-uppercase py-0 font-weight-light caption"
            >
              ESTADO: {{affiliate_guarantor.affiliate.affiliate_state.name}}
            </v-col>
              </v-row>
            </v-col>
            <v-progress-linear></v-progress-linear>
            <!--v-col
              cols="12"
              md="8"
              class="error--text font-weight-black caption py-0"
            >
              AFILIADO CON DOBLE PERCEPCION
            </v-col>-->
            <template v-if="show_spouse">
            <v-col cols="12" md="12" class="font-weight-black caption ma-0 py-0">
            <v-row>
              <v-col cols="12" md="8" class="font-weight-black caption py-0">
                DATOS DE LA CONGUYE
              </v-col>
              <v-col
                cols="12"
                md="12"
                class="text-uppercase py-0 font-weight-light caption"
              >
                CONGUYE: {{$options.filters.fullName(affiliate_guarantor.affiliate.spouse, true)}}
              </v-col>
              <v-col
                cols="12"
                md="6"
                class="text-uppercase py-0 font-weight-light caption"
              >
                C.I.: {{affiliate_guarantor.affiliate.spouse.identity_card}}
              </v-col>
            </v-row>
            </v-col>
            </template>
          </v-card>
        </v-col>

        <v-col cols="12" md="12" v-if="show_garante && affiliate_guarantor.guarantor">
          <v-card class="pa-2">
            <v-row>
            <v-col cols="12" md="12" class="font-weight-black caption py-0">
              NRO DE PRÉSTAMOS {{guarantors.length}} {{$route.query.loan_id}}
            </v-col>

            <v-col
              cols="12" md="6"
              class="text-uppercase py-0 font-weight-light caption"
            >
              VIGENTES Y EN PROCESO: {{affiliate_guarantor.affiliate.active_loans}}
            </v-col>
            <v-col
              cols="12" md="6"
              class="text-uppercase py-0 font-weight-light caption"
            >
              GARANTIZANDOS: {{affiliate_guarantor.guarantees ? affiliate_guarantor.guarantees.length : 0}}
            </v-col>
            <v-col cols="12" md="12" class="font-weight-black caption py-2">
              <v-progress-linear></v-progress-linear>
              GARANTIAS ACTIVAS
            </v-col>
            <v-col cols="12" md="12" class="caption py-0">
            <v-data-table
              dense
              :headers="headers"
              :items="affiliate_guarantor.guarantees"
              :items-per-page="affiliate_guarantor.guarantees.length"
              show-select
              v-model="selectedGuaranteedLoans"
              hide-default-footer
            >
              <template v-slot:[`header.data-table-select`]="{ on, props }">
                <v-simple-checkbox color="info" class="grey lighten-3" v-bind="props" v-on="on"></v-simple-checkbox>
              </template>
              <template v-slot:[`item.data-table-select`]="{ isSelected, select }">
                <v-simple-checkbox color="success" :value="isSelected" @input="select($event)"></v-simple-checkbox>
              </template>
              <template v-slot:[`item.quota`]="{ item }">
                {{ item.quota | money}}
              </template>
            </v-data-table>

            </v-col>
            </v-row>
          </v-card>
        </v-col>
        <!--Retroceder meses-->
        <v-col cols="12" class="my-0" v-if="show_garante && affiliate_guarantor.guarantor">
          <v-card class="pa-2 my-0">
            <v-row class="pa-0 my-0">
              <v-col cols="12" md="2" class="py-0 my-0">
                <v-text-field
                  dense
                  v-model="number_diff_month"
                  label="Retroceder meses"
                  color="info"
                  append-icon="mdi-plus-box"
                  prepend-icon="mdi-minus-box"
                  @click:append="appendIconCallback"
                  @click:prepend="prependIconCallback"
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <!-- Panel del las boletas-->
            <v-row v-for="(contrib,i) in contribution" :key="i" class="py-0 my-0">
              <v-col cols="12" md="7" class="py-0 my-0">
                <v-row>
                  <v-col cols="12" md="12" class="py-0 my-0 pb-1 uppercase"> BOLETAS DE PAGO <b>{{contribution[i].month}}</b></v-col>
                  <v-col cols="12" md="3" class="py-0 my-0" v-if="lender_contribution.state_affiliate != 'Comisión'">
                    <ValidationProvider
                      v-slot="{ errors }"
                      name="Boleta de pago"
                      :rules="'required|min_value:' + global_parameters.livelihood_amount"
                      mode="aggressive"
                    >
                      <b style="text-align: center"></b>
                      <v-text-field
                        :error-messages="errors"
                        dense
                        v-model="contribution[i].payable_liquid"
                        label="Liquido pagable"
                        :disabled="!enabled"
                        :outlined="editar"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" class="py-0 my-0"  :md="lender_contribution.state_affiliate == 'Comisión' ? 4 : 2">
                    <ValidationProvider
                      v-slot="{ errors }"
                      name="Monto ajuste"
                      :rules="''"
                      mode="aggressive"
                    >
                      <b style="text-align: center"></b>
                      <v-text-field
                        :error-messages="errors"
                        dense
                        v-model="contribution[i].adjustment_amount"
                        :label= "lender_contribution.state_affiliate == 'Comisión' ? 'Liquido pagable' :  'Monto ajuste'"
                        :outlined = "!(contribution[i].payable_liquid == 0 && lender_contribution.state_affiliate != 'Comisión')? true : false"
                        :disabled = "!(contribution[i].payable_liquid == 0 && lender_contribution.state_affiliate != 'Comisión')? false : true"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <template v-if="lender_contribution.state_affiliate != 'Comisión'">
                    <v-col cols="12" md="2" class="py-0 my-0" >
                      <b style="text-align: center">= {{(parseFloat(contribution[i].adjustment_amount) + parseFloat(contribution[i].payable_liquid)) | money}}</b>
                    </v-col>
                    <v-col cols="12" md="5" class="py-0 my-0">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Descripción"
                        :rules="''"
                        mode="aggressive"
                      >
                        <b style="text-align: center"></b>
                        <v-textarea
                          :error-messages="errors"
                          dense
                          v-model="contribution[i].adjustment_description"
                          label="Descripción ajuste"
                        :outlined = "!(contribution[i].payable_liquid == 0 && lender_contribution.state_affiliate != 'Comisión')? true : false"
                        :disabled = "!(contribution[i].payable_liquid == 0 && lender_contribution.state_affiliate != 'Comisión')? false : true"
                          rows="1"
                        ></v-textarea>
                      </ValidationProvider>
                    </v-col>
                  </template>
                </v-row>
              </v-col>
              <v-col cols="12" md="5" class="py-0 my-0">
                <v-row class="py-0 my-0">
                  <v-col cols="12" md="12" class="py-0 my-0" v-if="lender_contribution.state_affiliate != 'Comisión'"> BONOS </v-col>
                  <template v-if="lender_contribution.state_affiliate == 'Activo'">
                    <v-col cols="12" md="3" class="py-0 my-0">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Bono Frontera"
                        :rules="''"
                        mode="aggressive"
                      >
                        <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="contribution[i].border_bonus"
                          label="Bono Frontera"
                          :disabled="!enabled"
                          :outlined="editar"
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12" md="3" class="py-0 my-0">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Bono Oriente"
                         :rules="''"
                        mode="aggressive"
                      >
                        <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="contribution[i].east_bonus"
                          label="Bono Oriente"
                          :disabled="!enabled"
                          :outlined="editar"
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12" md="3" class="py-0 my-0">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Bono Cargo"
                        :rules="''"
                        mode="aggressive"
                      >
                        <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="contribution[i].position_bonus"
                          label="Bono Cargo"
                          :disabled="!enabled"
                          :outlined="editar"
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12" md="3" class="py-0 my-0">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Bono Seguridad Ciudadana"
                         :rules="''"
                        mode="aggressive"
                      >
                        <v-text-field
                          :error-messages="errors"
                          dense
                          v-model="contribution[i].public_security_bonus"
                          label="Bono Seguridad Ciudadana"
                          :disabled="!enabled"
                          :outlined="editar"
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                 </template>
                  <v-col cols="12" :md="lender_contribution.state_affiliate == 'Pasivo' ? 4 : 3" class="py-0 my-0" v-if="lender_contribution.state_affiliate == 'Pasivo'">
                    <ValidationProvider
                      v-slot="{ errors }"
                      name="Renta dignidad"
                      :rules="''"
                      mode="aggressive"
                    >
                      <v-text-field
                        :error-messages="errors"
                        dense
                        v-model="contribution[i].dignity_rent"
                        label="Renta dignidad"
                        :disabled="!enabled"
                        :outlined="editar"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12" md="12" align ="center">
                <v-btn
                class="py-0 text-center"
                color="info"
                rounded small
                @click.stop="validateContributions()"
                  >Evaluar Garante
                </v-btn>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <!-- Respuesta evaluación de garante -->
        <v-col cols="12" md="6" class="py-0" v-if="show_garante && affiliate_guarantor.guarantor && Object.keys(evaluate_garantor).length !== 0 && valid_contrib"
          ><v-card class="pa-2">

              Cantidad de garantes faltantes a añadir: {{ modalidad_guarantors - guarantor_detail.length }}

            <v-progress-linear></v-progress-linear>
            <p class="py-0 mb-0 ">
              Liquido Total: {{ evaluate_garantor.payable_liquid_calculated | moneyString }}<br />
              Total de Bonos: {{ evaluate_garantor.bonus_calculated | moneyString }}<br />
              Liquido para Calificacion: {{ evaluate_garantor.liquid_qualification_calculated | moneyString }}
            </p>
            <p class="py-0 mb-0 " >
              Indice de Endeudamiento: {{ evaluate_garantor.indebtnes_calculated | percentage }}%<br />
              Liquido Restante para garantias: {{ evaluate_garantor.liquid_rest | moneyString }}<br />
            </p>
            <p v-if="evaluate_garantor.is_valid">
            <span class="green--text font-weight-black">Cubre la Cuota</span>
            </p>
            <span class="red--text font-weight-black" v-else >No Cubre la Cuota</span>

            <div class="text-right" v-show="evaluate_garantor.is_valid">
              <v-btn
                v-show="guarantor_detail.length < modalidad_guarantors"
                x-small
                class="py-0"
                color="info"
                rounded
                @click="validateAddGuarantor()"
                >Añadir Garante
              </v-btn>
            </div>
          </v-card>
        </v-col>

        <v-col cols="12" md="6" class="py-0" v-if="!show_garante">
        </v-col>
        <v-col cols="12" md="6" class="py-0" v-if="guarantors.length == 0">
        </v-col>

        <v-col cols="12" md="6" class="py-0" v-if="guarantors.length > 0">
          <v-card class="pa-2">
            {{ "Cantidad de garantes a añadir: " + modalidad_guarantors }}
            <v-progress-linear></v-progress-linear>
            <div
              class="align-end font-weight-light ma-0 pa-0"
              v-for="(guarantor, index) of guarantor_detail"
              :key="index"
            >
             <strong> {{ index + 1 + ". " }} {{ guarantor.fullname }}</strong>
              <v-btn text icon color="error" @click.stop="deleteGuarantor(index)"
                >X</v-btn
              ><br />
              Liquido para Calificacion: {{guarantor.liquid_qualification_calculated | moneyString }}<br />
              Indice de Endeudamiento: {{ guarantor.indebtedness_calculated | percentage }}%<br />
              Porcentaje de Pago: {{ guarantor.payment_percentage | moneyString }}<br />
              Cuota: {{guarantor.quota_treat}}
              <v-divider></v-divider>
            </div>
            <!--<div
              class="text-right"
              v-if="modalidad_guarantors == guarantor_detail.length"
            >
              <v-btn
                class="py-0"
                color="info"
                rounded
                x-small
                @click="simulator()"
                >Calculo de Cuota
              </v-btn> 
            </div>-->
          </v-card>
        </v-col>

        <!--<v-col cols="4" class="py-0"
          ><v-card>
            <v-row class="py-0">
              <v-col cols="12" md="4" style="color: teal" class="py-0">
                Monto del Prestamo: {{ loan_detail.amount_requested }}
              </v-col>
              <v-col cols="12" md="4" style="color: teal" class="py-0">
                Plazo del Prestamo:{{ loan_detail.months_term }}
              </v-col>
              <v-col cols="12" md="4" style="color: teal" class="py-0">
                Cuota del Titular:{{
                  simulator_guarantors.quota_calculated_estimated_total
                }}
              </v-col>
            </v-row>
            <ul style="list-style: none" class="pa-0">
              <li
                v-for="(afiliados, i) in simulator_guarantors.affiliates"
                :key="i"
              >
                <v-progress-linear></v-progress-linear>
                <v-row>
                  <v-col cols="12" md="12" class="py-0">
                    Nombre del Afiliado: {{ guarantor_detail[i] }}
                  </v-col>
                  <v-col cols="12" md="3" class="py-0">
                    Cuota: {{ afiliados.quota_calculated }}
                  </v-col>
                  <v-col cols="12" md="5" class="py-0">
                    Indice de Endeudamiento:
                    {{ afiliados.indebtedness_calculated | percentage }}%
                  </v-col>
                  <v-col cols="12" md="4" class="py-0">
                    Porcentaje de Pago:
                    {{ (" " + afiliados.payment_percentage) | percentage }}%
                  </v-col>
                </v-row>
              </li>
            </ul>
          </v-card>
        </v-col> -->
      </template>
    </v-row>
    <v-card> </v-card>
  </v-container>
</template>


<script>

  export default {
  name: "loan-guarantor",
   props: {
    loan_detail: {
      type: Object,
      required: true
    },
    global_parameters:{
      type: Object,
      required:true
    },
    guarantors: {
      type: Array,
      required: true
    },
     affiliate: {
      type: Object,
      required: true
    },
    //Cantidad de garantes de acuerdo a la modalidad
    modalidad_guarantors: {
      type: Number,
      required: true,
      default: 0
    },
    modalidad_id: {
      type: Number,
      required: true,
      default: 0
    },
    modalidad: {
      type: Object,
      required: true
    },
    data_loan_parent_aux: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    guarantor_ci:null,
    affiliate_guarantor:{
      affiliate:{
        category:{},
        affiliate_state:{},
        full_name:null
      },
      //guarantees_sismu:[],
      //loans_sismu:[]
    },
    //affiliate_id:null,
    //spouse:{},
    //name_guarantor:null,
    //double_perception:false,
    type_affiliate:false,
    //amount_adjustable_description:null,
    //number_diff_month:1,
    //period:null,
    //back_months:false,
    //data_ballots_state_affiliate:null,
    //period_ballots:null,
    //amount_adjustable:0,
    //data_ballots_name:null,
    //contributionable:[],
    //loan_contributions_adjust_ids:[],
    //guarantor_ballots:{},
    //data_ballots:[],
    //simulator_guarantors:{},
    //loan:[],
    //index: [],
    //guarantor_objet:{},
    guarantor_detail:[],
    //guarantor_simulator:[],
    //payable_liquid:[0],
    //bonos:[0,0,0,0],
    evaluate_garantor:{},
    headers: [
      {
        text: "Codigo",
        class: ["normal", "white--text"],
        align: "left",
        value: "code",
        width: "20%"
      },
      {
        text: "Titular",
        class: ["normal", "white--text"],
        align: "left",
        value: "lender",
        width: "35%"
      },
      {
        text: "Cuota garante",
        class: ["normal", "white--text"],
        align: "left",
        value: "quota"
      },
      {
        text: "Tipo Trámite",
        class: ["normal", "white--text"],
        align: "left",
        value: "type"
      },
      {
        text: "Estado",
        class: ["normal", "white--text"],
        align: "left",
        value: "state"
      },
    ],
    //Variables que activan los imputs para editar
    //edit_commission:false,
    //edit_contributions:true,
    //edit_passive:true,
    //Variables que sirven de visualizacion de los paneles y botones
    //show_contributios:true,
    //show_commission:false,
    //show_passive:false,
    //spouse_view:false,
    show_data:true,
    //show_ajuste:true,
    //show_simulador:false,
    show_garante:false,
    //show_calculated:false,
    //show_result:false,
    //show_guarantor_false:true,
    //show_guarantor_true:false,
    //nuevas variables
    existence_garantor: {
      existence: false,
      double_perception: false,
      type: null
    },
    show_spouse:false,
    choose_diff_month: false,
    number_diff_month: 1,
    lender_contribution: {},
    contribution: [],
    modalidad_gar:{//cantidad de boletas para el garante
      quantity_ballots: 1
     },
    data_ballots: [],
    selectedGuaranteedLoans: [],
    enabled: false,
    editar: true,
    contributions: [],

    //contributionable_type: null,
    //loan_contributions_adjust_ids: [],
    contributionable_ids: [],
    affiliate_contribution: {},
    loan_contribution_guarantee_register_ids: [],
    guarantor: {},
    valid_contrib: false

  }),
 watch:{
   guarantor_ci: function(newVal, oldVal){
     if(newVal != oldVal)
     this.clear()
   },
   selectedGuaranteedLoans: function(newVal, oldVal){
     if(newVal != oldVal)
     this.valid_contrib= false
   },
 },
  computed: {
    remake() {
      if(this.$route.params.hash == 'remake'){
        return true
      }else{
        return false
      }
    }
  },
  methods:{
    //Metodo para limpiar los imputs
    async clear()
    {
      this.show_garante=false
      //this.show_calculated=false
      /*this.edit_contributions=true
      this.payable_liquid[0]=0,
      this.bonos[0]=0
      this.bonos[1]=0
      this.bonos[2]=0
      this.bonos[3]=0*/
      //this.amount_adjustable=0
      //this.amount_adjustable_description=null
      this.number_diff_month=1,
      this.choose_diff_month= false,
      //nuevas variables para limpieza

      this.existence_garantor.existence= false,
      this.existence_garantor.double_perception= false,
      this.existence_garantor = {
        existence: false,
        double_perception: false,
        type: null
      },
        this.data_ballots = [],
    this.selectedGuaranteedLoans = [],
    this.evaluate_garantor ={}
    },

    async searchGuarantor()
    {
      try {
      this.choose_diff_month = false
      this.number_diff_month = 1
        if(this.guarantor_ci != this.affiliate.identity_card){
          let res = await axios.post(`existence`,{
            identity_card: this.guarantor_ci,
          })
          this.existence_garantor = res.data
             if(this.existence_garantor.existence){
              if(this.existence_garantor.double_perception){

                //Obtener en type_affiliate si es afiliado o conyugue y consultar segunda ruta
                let res1 = await axios.post(`validate_guarantor`,{
                  affiliate_id: !this.type_affiliate && this.existence_garantor.type == 'affiliate' ? this.existence_garantor.affiliate : this.existence_garantor.deceased_affiliate,
                  procedure_modality_id: this.modalidad_id,
                  remake_loan_id: !this.remake ? 0 : this.$route.query.loan_id
                } )
                this.affiliate_guarantor = res1.data
                if(this.type_affiliate)
                {
                    this.show_garante=true
                    this.show_spouse=true
                    this.getBallots(this.affiliate_guarantor.affiliate.id)
                    //this.toastr.error("como esposa")
                }else{
                  this.show_garante=true
                  this.show_spouse= false
                  this.getBallots(this.affiliate_guarantor.affiliate.id)
                  //this.toastr.error("como titular")
                }
              }else{
                //Enviar a la segunda ruta el id del afiliado
                let res1 = await axios.post(`validate_guarantor`,{
                  affiliate_id: this.existence_garantor.affiliate,
                  procedure_modality_id: this.modalidad_id,
                  remake_loan_id: !this.remake ? 0 : 1
                } )
                this.affiliate_guarantor = res1.data
                if(this.existence_garantor.type == 'spouse')
                {
                    this.show_garante=true
                    this.show_spouse=true
                    this.getBallots(this.affiliate_guarantor.affiliate.id)
                    this.toastr.error("ES esposa")
                } else if (this.existence_garantor.type == 'affiliate'){
                  this.show_garante=true
                  this.show_spouse=false
                  this.getBallots(this.affiliate_guarantor.affiliate.id)
                  this.toastr.error("ES TITULAR")
                } else {
                  this.toastr.error("No se encontraron resultados como afiliado ni conyuge")
                }
                //this.toastr.error("No es doble percepcion")
              }
            }else{
              this.toastr.error("No puede ser garante")
            }
      }
       else
        {
          this.toastr.error("El garante no puede tener el mismo carnet que el titular.")
        }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },

    async getBallots(id) {
      try {
        this.data_ballots=[]
        let res = await axios.get(`affiliate/${id}/contribution`, {
           params:{
             city_id: this.$store.getters.cityId,
             choose_diff_month: this.choose_diff_month,
             number_diff_month: this.number_diff_month,
             sortBy: ['month_year'],
             sortDesc: [1],
             per_page: 1,
             page: 1,
           }
          })
        this.lender_contribution = res.data
        this.affiliate_contribution.valid = this.lender_contribution.valid
        this.affiliate_contribution.state_affiliate = this.lender_contribution.state_affiliate
        this.affiliate_contribution.name_table_contribution = this.lender_contribution.name_table_contribution
        this.data_ballots = res.data.data
        this.fecha= new Date();
        this.generateContributions()
        for (let i = 0; i < this.modalidad_gar.quantity_ballots; i++) {//colocar 1
          if(this.lender_contribution.valid && this.lender_contribution.state_affiliate =='Activo'){
            this.enabled = false
            this.editar=false
             //Carga los datos en los campos para ser visualizados en la interfaz
              this.contribution[i].contributionable_id = this.data_ballots[i].id
              this.contribution[i].payable_liquid = this.data_ballots[i].payable_liquid != null ? this.data_ballots[i].payable_liquid : 0
              this.contribution[i].border_bonus = this.data_ballots[i].border_bonus != null ? this.data_ballots[i].border_bonus : 0
              this.contribution[i].east_bonus = this.data_ballots[i].east_bonus != null ? this.data_ballots[i].east_bonus : 0
              this.contribution[i].position_bonus = this.data_ballots[i].position_bonus != null ? this.data_ballots[i].position_bonus : 0
              this.contribution[i].public_security_bonus = this.data_ballots[i].public_security_bonus != null ? this.data_ballots[i].public_security_bonus : 0
              this.contribution[i].period = this.$moment(this.data_ballots[i].month_year).format('YYYY-MM-DD')
              this.contribution[i].month = this.$moment(this.data_ballots[i].month_year).format('MMMM')

          } else if(!this.lender_contribution.valid && this.lender_contribution.state_affiliate =='Activo'){
              this.enabled = false
              this.editar=false
              this.contribution[i].contributionable_id = 0
              this.contribution[i].payable_liquid = 0
              this.contribution[i].border_bonus = 0
              this.contribution[i].east_bonus = 0
              this.contribution[i].position_bonus = 0
              this.contribution[i].public_security_bonus = 0
              this.contribution[i].period = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('YYYY-MM-DD')
              this.contribution[i].month = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('MMMM')

          } else if(this.lender_contribution.valid && this.lender_contribution.state_affiliate =='Pasivo'){
              this.enabled = true
              this.editar = true
              if(this.data_ballots[i]){
                this.contribution[i].contributionable_id = this.data_ballots[i].id
                this.contribution[i].payable_liquid = this.data_ballots[i].rent != null ? this.data_ballots[i].rent : 0
                this.contribution[i].dignity_rent = this.data_ballots[i].dignity_rent != null ? this.data_ballots[i].dignity_rent : 0
                this.contribution[i].period = this.$moment(this.data_ballots[i].month_year).format('YYYY-MM-DD')
                this.contribution[i].month = this.$moment(this.data_ballots[i].month_year).format('MMMM')
              }else{
                this.contribution[i].contributionable_id = 0
                this.contribution[i].payable_liquid = 0
                this.contribution[i].dignity_rent = 0
                this.contribution[i].period = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('YYYY-MM-DD')
                this.contribution[i].month = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('MMMM')
                }

          } else if(!this.lender_contribution.valid && this.lender_contribution.state_affiliate =='Pasivo'){
              this.enabled = true
              this.editar  = true
              this.contribution[i].contributionable_id = 0
              this.contribution[i].payable_liquid = 0
              this.contribution[i].dignity_rent = 0
              this.contribution[i].period = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('YYYY-MM-DD')
              this.contribution[i].month = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('MMMM')

          } else if(!this.lender_contribution.valid && this.lender_contribution.state_affiliate =='Comisión'){
              this.contribution[i].contributionable_id = 0
              this.contribution[i].payable_liquid = 0
              this.contribution[i].period = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('YYYY-MM-DD')
              this.contribution[i].month = this.$moment(this.lender_contribution.current_tiket).subtract(this.modalidad_gar.quantity_ballots-1-i,'months').format('MMMM')

          } else {
            this.toastr.error("Ocurrio caso especial de afiliado que no fue considerado.")}
        }

      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    generateContributions () {
      this.contribution = []
      for (let i = 0; i < this.modalidad_gar.quantity_ballots; i++) {
        this.contribution.push({
          contributionable_id: null,
          payable_liquid: 0,
          position_bonus: 0,
          border_bonus: 0,
          public_security_bonus: 0,
          east_bonus: 0,
          dignity_rent: 0,
          period: null,
          adjustment_amount: 0,
          adjustment_description: null,
          loan_contributions_adjust_id: null,
        })
      }
    },

    getContributions() {
      return this.contribution
    },

    validateContributions(){

        let continuar = false
        //validaciones de todas las contribuciones
        this.contributions = this.contribution
        for(let i = 0; i < this.contributions.length; i++){
          if((parseFloat(this.contributions[i].payable_liquid) + parseFloat(this.contributions[i].adjustment_amount)) >= this.global_parameters.livelihood_amount){
            continuar = true
            if( continuar == true && (parseFloat(this.contributions[i].position_bonus)+
            parseFloat(this.contributions[i].border_bonus)+
            parseFloat(this.contributions[i].public_security_bonus)+
            parseFloat(this.contributions[i].east_bonus)) <
            (parseFloat(this.contributions[i].payable_liquid) +
            parseFloat(this.contributions[i].adjustment_amount))){
              continuar = true
              if(continuar == true &&
              !(this.contributions[i].adjustment_amount > 0 &&
              (this.contributions[i].adjustment_description == null || this.contributions[i].adjustment_description == '') &&
              (this.affiliate_contribution.state_affiliate == 'Pasivo' || this.affiliate_contribution.state_affiliate == 'Activo'))){
                  continuar = true
              }else{
                  continuar = false
                  this.toastr.error('Existe un ajuste en el mes de '+this.contributions[i].month.toUpperCase()+ " ingrese descripción del ajuste")
                  break;
              }
            }else{
              continuar = false
              this.toastr.error(this.contributions[i].month.toUpperCase()  + " La sumatoria de bonos debe ser menor al Liquido pagable")
              break;
            }
          }else{
            continuar = false
            this.toastr.error(this.contributions[i].month.toUpperCase()  +" El 'Liquido Pagable' + 'Monto Ajuste' debe ser mayor ó igual al Monto de subsistencia que son "+this.global_parameters.livelihood_amount+" Bs.")
            break;
          }
        }
        if(continuar){
          //Evaluar al garante
          this.valid_contrib = true
          this.evaluateGuarantor()
        }else{
          this.valid_contrib = false
          this.toastr.error('No se puede evaluar el garante')
        }


    },

    async evaluateGuarantor(){
      try { 
          //Evaluar al garante
          let res = await axios.post(`evaluate_garantor2`,{
            procedure_modality_id: this.modalidad_id,
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            quota_calculated_total_lender: this.loan_detail.quota_calculated_total_lender,
            contributions: [
              {
                payable_liquid: parseFloat(this.contribution[0].payable_liquid) + parseFloat(this.contribution[0].adjustment_amount),
                position_bonus: this.contribution[0].position_bonus,
                border_bonus: this.contribution[0].border_bonus,
                public_security_bonus: this.contribution[0].public_security_bonus,
                east_bonus: this.contribution[0].east_bonus,
                dignity_rent: this.contribution[0].dignity_rent,
              }
            ],
            guarantees: this.selectedGuaranteedLoans
          })
        this.evaluate_garantor = res.data


      } catch (e) {
        console.log(e)
      } finally {
        //this.loading = false
      }
    },


    //Ajuste del Titular
    /*async saveAdjustment(){
      try {
      this.loan_contributions_adjust_ids = []
      this.contributionable_ids = []
      console.log(this.contributionable_ids)

      this.contributions = this.contribution

      this.contributions.forEach(async (item, i) => {
        //Verificar si el afiliado es pasivo para introducir su contribución
        if(this.affiliate_contribution.state_affiliate == 'Pasivo'){
          let res = await axios.post(`aid_contribution/updateOrCreate`,{
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            month_year: this.contributions[i].period,
            rent: this.contributions[i].payable_liquid,
            dignity_rent: this.contributions[i].dignity_rent,
          })
          debugger
          let contribution_passive = res.data
            this.contributions[i].contributionable_id = contribution_passive.id
            if (this.contributionable_ids.indexOf(this.contributions[i].contributionable_id) === -1) {
              this.contributionable_ids.push(this.contributions[i].contributionable_id)
            }
            this.contributionable_type = 'aid_contributions'
        }
        else if(this.affiliate_contribution.state_affiliate == 'Activo') {
          if (this.contributionable_ids.indexOf(this.contributions[i].contributionable_id) === -1) {
            this.contributionable_ids.push(this.contributions[i].contributionable_id)
          }
          this.contributionable_type = 'contributions'
        }
        else if(this.affiliate_contribution.state_affiliate == 'Comisión') {
          this.contributionable_type = 'loan_contribution_adjusts'
        }

        //Para el ajuste
        if(this.contributions[i].adjustment_amount > 0){ //aqui se debe colocar la edicion del ajuste, hacer condicional
          //guardar el ajuste
          let res = await axios.post(`loan_contribution_adjust/updateOrCreate`, {
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            adjustable_id: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.contributions[i].contributionable_id : this.$route.query.affiliate_id,
            adjustable_type: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.affiliate_contribution.name_table_contribution : 'affiliates',
            type_affiliate: 'guarantor',
            amount: this.contributions[i].adjustment_amount,
            type_adjust: this.affiliate_contribution.state_affiliate != 'Comisión' ? 'adjust' : 'liquid',
            period_date: this.contributions[i].period,
            description: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.contributions[i].adjustment_description : 'Liquido pagable por Comisión'
          })
          this.contributions[i].loan_contributions_adjust_id = res.data.id
          console.log(this.contributions[i].loan_contributions_adjust_id)
          if (this.loan_contributions_adjust_ids.indexOf(this.contributions[i].loan_contributions_adjust_id) === -1) {
            this.loan_contributions_adjust_ids.push(this.contributions[i].loan_contributions_adjust_id)
          }

        }else{
          console.log('No tiene ajuste')
        }
      })
      }
      catch (e){
        console.log(e)
      }
    },

    /*async registrationGuaranteedLoans(){
      try {
        let res = await axios.post(`loan_contribution_adjust/updateOrCreateLoanGuaranteeRegister`,{
          affiliate_id: this.affiliate_guarantor.affiliate.id,
          guarantees: this.selectedGuaranteedLoans
        })
        this.guarantor.loan_contribution_guarantee_register_ids = res.data.loan_contribution_guarantee_register_ids
        //this.guarantor.loan_contribution_guarantee_register_ids = this.loan_contribution_guarantee_register_ids
      } catch (e) {
        console.log(e)
      }
    },*/

    validateAddGuarantor(){
      if(this.affiliate_guarantor.information){
        if(this.guarantor_detail.length>0){
          if(this.affiliate_guarantor.affiliate.id == this.guarantor_detail[0].affiliate_id){
            this.toastr.error("Este afiliado ya se encuentra registrado.")
          }else{
            this.addGuarantor()
            //this.show_garante = false
          }
        }else{
          this.addGuarantor()
          //this.show_garante = false
        }
      }else{
        this.toastr.error("Debe registrar la información faltante del garante.")
      }

    },

    async addGuarantor(){
      try {

        this.guarantor = {}
        this.guarantor.loan_contribution_guarantee_register_ids = []

        //this.saveAdjustment()

        // registro de garantias de prestamos
        if(this.selectedGuaranteedLoans.length > 0){
          let res = await axios.post(`loan_contribution_adjust/updateOrCreateLoanGuaranteeRegister`,{
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            guarantees: this.selectedGuaranteedLoans
          })
          this.guarantor.loan_contribution_guarantee_register_ids = res.data.loan_contribution_guarantee_register_ids
        }
        //Inico ajuste
      this.loan_contributions_adjust_ids = []
      let contributionable_ids = []
      let contributionable_type = null
      console.log(contributionable_ids)

      this.contributions = this.contribution

 
        //Verificar si el afiliado es pasivo para introducir su contribución
        if(this.affiliate_contribution.state_affiliate == 'Pasivo'){
          let res = await axios.post(`aid_contribution/updateOrCreate`,{
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            month_year: this.contributions[0].period,
            rent: this.contributions[0].payable_liquid,
            dignity_rent: this.contributions[0].dignity_rent,
          })

          let contribution_passive = res.data
            this.contributions[0].contributionable_id = contribution_passive.id
            if (contributionable_ids.indexOf(this.contributions[0].contributionable_id) === -1) {
              contributionable_ids.push(this.contributions[0].contributionable_id)
               this.guarantor.contributionable_ids = contributionable_ids
            }
            contributionable_type = 'aid_contributions'
            this.guarantor.contributionable_type = contributionable_type
        }
        else if(this.affiliate_contribution.state_affiliate == 'Activo') {
          if (contributionable_ids.indexOf(this.contributions[0].contributionable_id) === -1) {
            contributionable_ids.push(this.contributions[0].contributionable_id)
             this.guarantor.contributionable_ids = contributionable_ids
          }
          contributionable_type = 'contributions'
          this.guarantor.contributionable_type = contributionable_type
        }
        else if(this.affiliate_contribution.state_affiliate == 'Comisión') {
          contributionable_type = 'loan_contribution_adjusts'
          this.guarantor.contributionable_type = contributionable_type
        }

        //Para el ajuste
        if(this.contributions[0].adjustment_amount > 0){ //aqui se debe colocar la edicion del ajuste, hacer condicional
          //guardar el ajuste
          let res = await axios.post(`loan_contribution_adjust/updateOrCreate`, {
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            adjustable_id: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.contributions[0].contributionable_id : this.$route.query.affiliate_id,
            adjustable_type: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.affiliate_contribution.name_table_contribution : 'affiliates',
            type_affiliate: 'guarantor',
            amount: this.contributions[0].adjustment_amount,
            type_adjust: this.affiliate_contribution.state_affiliate != 'Comisión' ? 'adjust' : 'liquid',
            period_date: this.contributions[0].period,
            description: this.affiliate_contribution.state_affiliate != 'Comisión' ? this.contributions[0].adjustment_description : 'Liquido pagable por Comisión'
          })
          this.contributions[0].loan_contributions_adjust_id = res.data.id
          console.log(this.contributions[0].loan_contributions_adjust_id)
          if (this.loan_contributions_adjust_ids.indexOf(this.contributions[0].loan_contributions_adjust_id) === -1) {
            this.loan_contributions_adjust_ids.push(this.contributions[0].loan_contributions_adjust_id)
          }

        }else{
          console.log('No tiene ajuste')
        }


        //fin ajuste
        this.guarantor.affiliate_id = this.affiliate_guarantor.affiliate.id,
        this.guarantor.bonus_calculated = this.evaluate_garantor.bonus_calculated,
        this.guarantor.contributionable_ids = contributionable_ids,
        this.guarantor.contributionable_type = contributionable_type,
        this.guarantor.indebtedness_calculated = this.evaluate_garantor.indebtnes_calculated
        this.guarantor.liquid_qualification_calculated = this.evaluate_garantor.liquid_qualification_calculated,
        this.guarantor.loan_contributions_adjust_ids = this.loan_contributions_adjust_ids,
        this.guarantor.payable_liquid_calculated = this.evaluate_garantor.payable_liquid_calculated,
        this.guarantor.payment_percentage = this.evaluate_garantor.payment_percentage,
        this.guarantor.quota_treat = this.evaluate_garantor.quota_calculated

        this.guarantors.push(this.guarantor)

        if (this.type_affiliate || (this.existence_garantor.type == 'spouse')){
        this.guarantor.fullname = this.$options.filters.fullName(this.affiliate_guarantor.affiliate.spouse, true)
        this.guarantor.ci = this.affiliate_guarantor.affiliate.spouse.identity_card
        }
        else if (!this.type_affiliate || (this.existence_garantor.type == 'affiliate')){
          this.guarantor.fullname = this.$options.filters.fullName(this.affiliate_guarantor.affiliate, true)
          this.guarantor.ci =  this.affiliate_guarantor.affiliate.identity_card
        } else {
          this.toastr.error('No existen coincidencias de afiliados')
        }

        this.guarantor_detail.push(this.guarantor)
      } catch (e) {
        console.log(e)
      }
    },

    deleteGuarantor(i) {
      this.guarantors.splice(i, 1)
      this.guarantor_detail.splice(i, 1)

    },

    //Retrocede las contribuciones
    appendIconCallback () {
      if(this.number_diff_month < this.global_parameters.max_months_go_back){
        this.number_diff_month++
        this.choose_diff_month = true
        this.getBallots(this.affiliate_guarantor.affiliate.id)
      }
    },
    prependIconCallback () {
      if(this.number_diff_month > 1){
        this.number_diff_month--
        this.choose_diff_month = true
        this.getBallots(this.affiliate_guarantor.affiliate.id)
      }
    },
  }
  /*methods: {
    //Metodo para limpiar los imputs
    async clear()
    {
      this.show_garante=true
      this.show_calculated=false
      this.edit_contributions=true
      this.payable_liquid[0]=0,
      this.bonos[0]=0
      this.bonos[1]=0
      this.bonos[2]=0
      this.bonos[3]=0
      this.amount_adjustable=0
      this.amount_adjustable_description=null
      this.number_diff_month=1
    },
    //Metodo para borrar un garante adicionado
    deleteGuarantor(i) {
      this.show_simulador=false
      this.guarantor_detail.splice(i, 1)
      this.guarantor_simulator.splice(i, 1)
      this.guarantors.splice(i, 1)
      this.contributionable.splice(i, 1)
      this.loan_contributions_adjust_ids.splice(i, 1)

    },
    //Metodo para calcular las boletas
     async calculator() {
      try {
          if(this.amount_adjustable>0){
            if(this.amount_adjustable_description)
            {
              this.show_result=true
              this.show_data=true
                let res = await axios.post(`evaluate_garantor`, {
                procedure_modality_id:this.modalidad_id,
                affiliate_id:this.affiliate_guarantor.affiliate.id,
                quota_calculated_total_lender:this.loan_detail.quota_calculated_total_lender,
                remake_evaluation:this.$route.params.hash == 'remake' ? true : false,
                remake_loan_id: this.$route.params.hash == 'remake' ? this.$route.query.loan_id : null,
                contributions: [
                {
                  payable_liquid: parseFloat(this.payable_liquid[0]) + parseFloat(this.amount_adjustable),
                  position_bonus:  this.bonos[2],
                  border_bonus: this.bonos[0],
                  public_security_bonus: this.bonos[3],
                  east_bonus:this.bonos[1]
                }
                ]
              })
              this.evaluate_garantor= res.data
              this.loan_detail.simulador=false
            }else{
              this.toastr.error("Tiene que ingresar la descripcion del ajuste.")
            }
          }else{
            this.show_result=true
            this.show_data=true
            let res = await axios.post(`evaluate_garantor`, {
              procedure_modality_id:this.modalidad_id,
              affiliate_id:this.affiliate_guarantor.affiliate.id,
              quota_calculated_total_lender:this.loan_detail.quota_calculated_total_lender,
              contributions: [
              {
                payable_liquid: parseFloat(this.payable_liquid[0]) + parseFloat(this.amount_adjustable),
                position_bonus:  this.bonos[2],
                border_bonus: this.bonos[0],
                public_security_bonus: this.bonos[3],
                east_bonus:this.bonos[1]
              }
              ]
            })
            this.evaluate_garantor= res.data
            this.loan_detail.simulador=false
          }
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Metodo para sacar el porcentage de pago segun la cantidad de garantes
    async simulator() {
      try {
        this.show_simulador=true
        let res = await axios.post(`simulator`, {
          procedure_modality_id: this.modalidad_id,
          amount_requested: this.loan_detail.amount_requested,
          months_term: this.loan_detail.months_term,
          guarantor: true,
          liquid_qualification_calculated_lender: this.loan_detail.liquid_qualification_calculated + this.amount_adjustable,
          liquid_calculated:this.guarantor_simulator
        })
        this.simulator_guarantors = res.data
        for (this.j = 0; this.j< this.guarantors.length; this.j++) {
          this.guarantors[this.j].payment_percentage=this.simulator_guarantors.affiliates[this.j].payment_percentage
          this.guarantors[this.j].indebtedness_calculated=this.simulator_guarantors.affiliates[this.j].indebtedness_calculated
          this.guarantors[this.j].liquid_qualification_calculated=this.simulator_guarantors.affiliates[this.j].liquid_qualification_calculated
          this.guarantors[this.j].quota_treat=this.simulator_guarantors.affiliates[this.j].quota_calculated
        }
      this.loan_detail.simulador=true
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    //Metodo para la busqueda de garante por ci y matricula
    async searchGuarantor()
    {
      this.clear()
      try {
        if(this.guarantor_ci==this.affiliate.identity_card)
        {
          this.toastr.error("El garante no puede tener el mismo carnet que el titular.")
        }
        else
        {
          let resp = await axios.post(`affiliate_guarantor`,{
            identity_card: this.guarantor_ci,
            procedure_modality_id:this.modalidad_id,
            type_guarantor_spouse:this.type_affiliate,
            remake_evaluation:this.$route.params.hash == 'remake' ? true : false,
            remake_loan_id: this.$route.params.hash == 'remake' ? this.$route.query.loan_id : 0
          })
             if(resp.data.validate)
            {
              this.toastr.error(resp.data.validate)
            }else{
              this.affiliate_guarantor=resp.data
               this.double_perception= this.affiliate_guarantor.double_perception
              if(!this.double_perception)
              {
               if(this.affiliate_guarantor.affiliate.spouse == null  )
              {
                this.spouse_view = false
                this.name_guarantor=this.affiliate_guarantor.affiliate.full_name
                this.affiliate_id=this.affiliate_guarantor.affiliate.id
              }else{
                this.spouse_view = true
                this.spouse=this.affiliate_guarantor.affiliate.spouse
                this.name_guarantor=this.$options.filters.fullName(this.affiliate_guarantor.affiliate.spouse, true)

                  if(this.affiliate_guarantor.double_perception)
                  {
                    if(this.type_affiliate == false)
                    {
                      this.affiliate_id=this.affiliate_guarantor.affiliate.id
                    }else{
                      this.affiliate_id=this.spouse.affiliate_id
                    }
                  }else{
                      this.affiliate_id=this.affiliate_guarantor.affiliate.id
                  }
                }
                 let res = await axios.get(`affiliate/${this.affiliate_id}/contribution`, {
                params:{
                  city_id: this.$store.getters.cityId,
                  choose_diff_month: 1,
                  number_diff_month:1,
                  sortBy: ['month_year'],
                  sortDesc: [1],
                  per_page: 1,
                  page: 1,
                  }
                })
              this.data_ballots=res.data.data
              this.data_ballots_name=res.data.name_table_contribution
              this.data_ballots_state_affiliate=res.data.state_affiliate
              this.period=this.$moment(res.data.current_tiket).format('YYYY-MM-DD')
              if(res.data.name_table_contribution=='contributions')
              {
                if(res.data.valid)
                {
                 this.period_ballots=this.$moment(this.data_ballots[0].month_year).format('MMMM')

                  this.edit_contributions=false
                  this.show_contributios=true
                  this.show_commission=false
                  this.show_passive=false
                  this.back_months=true
                  this.show_ajuste=true
                  this.payable_liquid[0] = this.data_ballots[0].payable_liquid,
                  this.bonos[0] = this.data_ballots[0].border_bonus,
                  this.bonos[1] = this.data_ballots[0].east_bonus,
                  this.bonos[2] = this.data_ballots[0].position_bonus,
                  this.bonos[3] = this.data_ballots[0].public_security_bonus
                } else{

                  this.period_ballots=this.$moment(res.data.current_tiket).format('MMMM')

                  this.edit_contributions=false
                  this.show_contributios=true
                  this.show_commission=false
                  this.show_ajuste=true
                  this.show_passive=false
                  this.back_months=true
                  this.payable_liquid[0] = this.payable_liquid[0]
                  this.bonos[0] = this.bonos[0]
                  this.bonos[1] =this.bonos[1]
                  this.bonos[2] = this.bonos[2]
                  this.bonos[3] =this.bonos[3]
                }
              }else{
                if(res.data.name_table_contribution=='aid_contributions')
                {
                  this.show_passive= true
                  this.show_contributios=false
                  this.back_months=false
                  this.show_commission=false
                  this.show_ajuste=true

                if(res.data.valid)
                {
                  this.period_ballots=this.$moment(this.data_ballots[0].month_year).format('MMMM')
                  if(this.data_ballots[0].rent==0 && this.data_ballots[0].dignity_rent==0){
                    this.edit_contributions=true
                    this.edit_passive= true
                  }else{
                    if(this.data_ballots[0].dignity_rent>0 && this.data_ballots[0].rent>0){
                      this.edit_contributions=false
                      this.edit_passive= false
                      this.payable_liquid[0] = this.data_ballots[0].rent
                      this.bonos[0] = this.data_ballots[0].dignity_rent
                    }else{
                      if(this.data_ballots[0].dignity_rent==0){
                        this.edit_passive= true
                        this.edit_contributions=false
                        this.payable_liquid[0] = this.data_ballots[0].rent
                      }else{
                        if(this.data_ballots[0].rent==0){
                          this.edit_contributions=true
                          this.edit_passive= false
                          this.bonos[0] = this.data_ballots[0].dignity_rent
                        }
                      }
                    }
                  }
                } else{
                  this.period_ballots=this.$moment(res.data.current_tiket).format('MMMM')
                  this.edit_contributions=true
                  this.show_ajuste=true
              }
            }
            else{
              if(res.data.name_table_contribution==null)
              {
                this.period_ballots=this.$moment(res.data.current_tiket).format('MMMM')
                this.show_commission=true
                this.show_contributios=false
                this.show_passive=false
                this.show_ajuste=false
                this.back_months=false
              }
            }
          }
            this.show_guarantor_false=this.affiliate_guarantor.guarantor
            this.show_guarantor_true=this.affiliate_guarantor.guarantor
            this.show_calculated=this.affiliate_guarantor.guarantor
            this.loan=this.affiliate_guarantor.affiliate.loans
            this.show_garante=false

            }
          }
        }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    //Metodo para añadir al garante
    async addGuarantor()
    {
       let resp = await axios.post(`affiliate_guarantor`,{
            identity_card: this.guarantor_ci,
            procedure_modality_id:this.modalidad_id,
            type_guarantor_spouse:this.type_affiliate,
            remake_evaluation:this.$route.params.hash == 'remake' ? true : false,
            remake_loan_id: this.$route.params.hash == 'remake' ? this.$route.query.loan_id : 0
          })
      this.affiliate_guarantor.guarantor_information=resp.data.guarantor_information

      if(this.affiliate_guarantor.guarantor_information==true)
      {
      this.guarantor_ci=null
      this.show_data=false
      this.guarantor_ballots.affiliate_id=this.affiliate_guarantor.affiliate.id
      this.guarantor_ballots.liquid_qualification_calculated=this.evaluate_garantor.liquid_qualification_calculated
      this.guarantor_objet.affiliate_id=this.affiliate_guarantor.affiliate.id
      this.guarantor_objet.bonus_calculated=this.evaluate_garantor.bonus_calculated
      this.guarantor_objet.payable_liquid_calculated=this.evaluate_garantor.payable_liquid_calculated

      if(this.guarantors.length>0){
        if(this.guarantor_ballots.affiliate_id == this.guarantors[0].affiliate_id){
          this.toastr.error("Este afiliado ya se encuentra registrado.")
        }else{
          if(this.data_ballots_name==null)
      {
          let res = await axios.post(`loan_contribution_adjust`, {
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            adjustable_id:this.affiliate_guarantor.affiliate.id,
            adjustable_type: 'afilliates',
            type_affiliate:'guarantor',
            amount: this.payable_liquid[0],
            type_adjust: 'liquid',
            period_date: this.period,
            description: 'Liquido Pagable Comision',
          })
        this.guarantor_objet.contributionable_ids=this.contributionable
        this.guarantor_objet.contributionable_type='loan_contribution_adjusts'
        this.loan_contributions_adjust_ids.push(res.data.id)
        this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
      }else{
        if(this.data_ballots_state_affiliate=='Pasivo'){
          let res_aid_contribution = await axios.post(`aid_contribution/updateOrCreate`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              month_year: this.period,
              rent: this.payable_liquid[0],
              dignity_rent: this.bonos[0],
          })
          this.contributionable.push(res_aid_contribution.data.id)
          this.guarantor_objet.contributionable_ids=this.contributionable
          this.guarantor_objet.contributionable_type=this.data_ballots_name

          if(this.amount_adjustable>0){
            let res_adjust_pasivo= await axios.post(`loan_contribution_adjust`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              adjustable_id:res_aid_contribution.data.id,
              adjustable_type: this.data_ballots_name,
              type_affiliate:'guarantor',
              amount: this.amount_adjustable,
              type_adjust: 'adjust',
              period_date: this.period,
              description: this.amount_adjustable_description,
            })
            this.loan_contributions_adjust_ids.push(res_adjust_pasivo.data.id)
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }else{
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }
        }else{

          this.contributionable.push(this.data_ballots[0].id)
          this.guarantor_objet.contributionable_ids=this.contributionable
          this.guarantor_objet.contributionable_type=this.data_ballots_name

          if(this.amount_adjustable>0){
            let res_adjust_activo = await axios.post(`loan_contribution_adjust`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              adjustable_id:this.data_ballots[0].id,
              adjustable_type: this.data_ballots_name,
              type_affiliate:'guarantor',
              amount: this.amount_adjustable,
              type_adjust: 'adjust',
              period_date: this.period,
              description: this.amount_adjustable_description,
            })
            this.loan_contributions_adjust_ids.push(res_adjust_activo.data.id)
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }else{
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }
        }
      }
        this.guarantor_detail.push(this.name_guarantor);
        this.guarantor_simulator.push(this.guarantor_ballots);
        this.guarantors.push(this.guarantor_objet);

        }
      }else{
        if(this.data_ballots_name==null)
      {
          let res = await axios.post(`loan_contribution_adjust`, {
            affiliate_id: this.affiliate_guarantor.affiliate.id,
            adjustable_id:this.affiliate_guarantor.affiliate.id,
            adjustable_type: 'afilliates',
            type_affiliate:'guarantor',
            amount: this.payable_liquid[0],
            type_adjust: 'liquid',
            period_date: this.period,
            description: 'Liquido Pagable Comision',
          })
        this.guarantor_objet.contributionable_ids=this.contributionable
        this.guarantor_objet.contributionable_type='loan_contribution_adjusts'
        this.loan_contributions_adjust_ids.push(res.data.id)
        this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
      }else{
        if(this.data_ballots_state_affiliate=='Pasivo'){
          let res_aid_contribution = await axios.post(`aid_contribution/updateOrCreate`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              month_year: this.period,
              rent: this.payable_liquid[0],
              dignity_rent: this.bonos[0],
          })
          this.contributionable.push(res_aid_contribution.data.id)
          this.guarantor_objet.contributionable_ids=this.contributionable
          this.guarantor_objet.contributionable_type=this.data_ballots_name

          if(this.amount_adjustable>0){
            let res_adjust_pasivo= await axios.post(`loan_contribution_adjust`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              adjustable_id:res_aid_contribution.data.id,
              adjustable_type: this.data_ballots_name,
              type_affiliate:'guarantor',
              amount: this.amount_adjustable,
              type_adjust: 'adjust',
              period_date: this.period,
              description: this.amount_adjustable_description,
            })
            this.loan_contributions_adjust_ids.push(res_adjust_pasivo.data.id)
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }else{
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }
        }else{

          this.contributionable.push(this.data_ballots[0].id)
          this.guarantor_objet.contributionable_ids=this.contributionable
          this.guarantor_objet.contributionable_type=this.data_ballots_name

          if(this.amount_adjustable>0){
            let res_adjust_activo = await axios.post(`loan_contribution_adjust`, {
              affiliate_id: this.affiliate_guarantor.affiliate.id,
              adjustable_id:this.data_ballots[0].id,
              adjustable_type: this.data_ballots_name,
              type_affiliate:'guarantor',
              amount: this.amount_adjustable,
              type_adjust: 'adjust',
              period_date: this.period,
              description: this.amount_adjustable_description,
            })
            this.loan_contributions_adjust_ids.push(res_adjust_activo.data.id)
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }else{
            this.guarantor_objet.loan_contributions_adjust_ids=this.loan_contributions_adjust_ids
          }
        }
      }
        this.guarantor_detail.push(this.name_guarantor);
        this.guarantor_simulator.push(this.guarantor_ballots);
        this.guarantors.push(this.guarantor_objet);
      }
        this.guarantor_ballots={}
        this.guarantor_objet={}
        this.loan_contributions_adjust_ids=[]
        this.contributionable=[]
        this.clear()
        console.log(this.guarantors)
    }else{
          this.toastr.error("Tiene que actualizar los datos personales del Garante.")
    }
    },
    //Metodo para retroceder las contribuciones del garante
    async backContributions(){
          let res = await axios.get(`affiliate/${this.affiliate_guarantor.affiliate.id}/contribution`, {
          params:{
            city_id: this.$store.getters.cityId,
            choose_diff_month: 1,
            number_diff_month:this.number_diff_month,
            sortBy: ['month_year'],
            sortDesc: [1],
            per_page: 1,
            page: 1,
          }
          })
          this.data_ballots=res.data.data
           if(res.data.valid)
            {
              this.period_ballots = this.$moment(this.data_ballots[0].month_year).format('MMMM')
              this.edit_contributions=false
              this.payable_liquid[0] = this.data_ballots[0].payable_liquid,
              this.bonos[0] = this.data_ballots[0].border_bonus,
              this.bonos[1] = this.data_ballots[0].east_bonus,
              this.bonos[2] = this.data_ballots[0].position_bonus,
              this.bonos[3] = this.data_ballots[0].public_security_bonus
            } else{
              this.period_ballots = this.$moment(res.data.current_tiket).format('MMMM')
              this.edit_contributions=false
              this.back_months=true
              this.payable_liquid[0] = 0
              this.bonos[0] = 0
              this.bonos[1] = 0
              this.bonos[2] = 0
              this.bonos[3] = 0
            }
    },
  //Retrocede las contribuciones
  appendIconCallback () {
      if(this.number_diff_month < this.global_parameters.max_months_go_back){
      this.number_diff_month++
      this.choose_diff_month = 1
      this.backContributions()
    }
  },
  //Aumenta las contribuciones
  prependIconCallback () {

      if(this.number_diff_month > 1){
      this.number_diff_month--
      this.choose_diff_month = 1
      this.backContributions()
    }
  },
  //Metodo para sacar las contribusiones cuando es doble percepcion
  async contributionChange(){
  try {
    if(this.type_affiliate)
      {
        let resp = await axios.post(`affiliate_spouse_guarantor`,{
            affiliate_id:  this.affiliate_guarantor.affiliate.id,
            procedure_modality_id:this.modalidad_id,
          })
        this.affiliate_guarantor=resp.data
       }else{
        let resp = await axios.post(`affiliate_spouse_guarantor`,{
            affiliate_id:  this.affiliate_guarantor.own_affiliate.id,
            procedure_modality_id:this.modalidad_id,
          })
        this.affiliate_guarantor=resp.data
      }
      if(this.affiliate_guarantor.affiliate.spouse == null  )
      {
        this.spouse_view = false
        this.name_guarantor=this.affiliate_guarantor.affiliate.full_name
        this.affiliate_id=this.affiliate_guarantor.affiliate.id
      }else{

        this.spouse_view = true
        this.spouse=this.affiliate_guarantor.affiliate.spouse
        this.name_guarantor=this.$options.filters.fullName(this.affiliate_guarantor.affiliate.spouse, true)

              if(this.affiliate_guarantor.double_perception)
              {
                if(this.type_affiliate == false)
                {
                  this.affiliate_id=this.affiliate_guarantor.affiliate.id
                }else{
                  this.affiliate_id=this.spouse.affiliate_id
                }
              }else{
                  this.affiliate_id=this.affiliate_guarantor.affiliate.id
              }
          }
          
          /////contribuciones
          let res = await axios.get(`affiliate/${this.affiliate_id}/contribution`, {
            params:{
              city_id: this.$store.getters.cityId,
              choose_diff_month: 1,
              number_diff_month:1,
              sortBy: ['month_year'],
              sortDesc: [1],
              per_page: 1,
              page: 1,
              }
          })
          this.data_ballots=res.data.data
          this.data_ballots_name=res.data.name_table_contribution
          this.data_ballots_state_affiliate=res.data.state_affiliate
          this.period=this.$moment(res.data.current_tiket).format('YYYY-MM-DD')
          if(res.data.name_table_contribution=='contributions')
          {
          // this.toastr.error("afiliado que pertenece a contribution")
            if(res.data.valid)
            {
              this.edit_contributions=false
              this.show_contributios=true
              this.show_commission=false
              this.show_passive=false
              this.back_months=true
              this.show_ajuste=true
              this.payable_liquid[0] = this.data_ballots[0].payable_liquid,
              this.bonos[0] = this.data_ballots[0].border_bonus,
              this.bonos[1] = this.data_ballots[0].east_bonus,
              this.bonos[2] = this.data_ballots[0].position_bonus,
              this.bonos[3] = this.data_ballots[0].public_security_bonus
            } else{
              this.edit_contributions=false
              this.show_contributios=true
              this.show_commission=false
              this.show_ajuste=true
              this.show_passive=false
              this.back_months=true
              this.payable_liquid[0] = this.payable_liquid[0]
              this.bonos[0] = this.bonos[0]
              this.bonos[1] =this.bonos[1]
              this.bonos[2] = this.bonos[2]
              this.bonos[3] =this.bonos[3]
            }
          }else{
            if(res.data.name_table_contribution=='aid_contributions')
            {
              this.show_passive= true
              this.show_contributios=false
              this.back_months=false
              this.show_commission=false
              this.show_ajuste=true

            if(res.data.valid)
            {
              if(this.data_ballots[0].rent==0 && this.data_ballots[0].dignity_rent==0){
                this.edit_contributions=true
                this.edit_passive= true
              }else{
                if(this.data_ballots[0].dignity_rent>0 && this.data_ballots[0].rent>0){
                  this.edit_contributions=false
                  this.edit_passive= false
                  this.payable_liquid[0] = this.data_ballots[0].rent
                  this.bonos[0] = this.data_ballots[0].dignity_rent
                }else{
                  if(this.data_ballots[0].dignity_rent==0){
                    this.edit_passive= true
                    this.edit_contributions=false
                    this.payable_liquid[0] = this.data_ballots[0].rent
                  }else{
                    if(this.data_ballots[0].rent==0){
                      this.edit_contributions=true
                      this.edit_passive= false
                      this.bonos[0] = this.data_ballots[0].dignity_rent
                    }
                  }
                }
              }
            } else{
                this.edit_contributions=true
                this.show_ajuste=true
              }
            }
            else{
              if(res.data.name_table_contribution==null)
              {
                this.show_commission=true
                this.show_contributios=false
                this.show_passive=false
                this.show_ajuste=false
                this.back_months=false
              }

            }
          }
            this.show_guarantor_false=this.affiliate_guarantor.guarantor
            this.show_guarantor_true=this.affiliate_guarantor.guarantor
            this.show_calculated=this.affiliate_guarantor.guarantor
            this.loan=this.affiliate_guarantor.affiliate.loans
            this.show_garante=false
            this.$forceUpdate();

          } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
      }
    } */
  }
</script>
<style scoped>
/*.theme--light.v-icon {
  color: blue !important;
}
.v-input--selection-controls__ripple.green--text {
   color: blue !important;
}*/
</style>
