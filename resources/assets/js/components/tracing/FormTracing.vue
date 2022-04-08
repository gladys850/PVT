<template>
  <v-container fluid class="py-0 px-0">
      <v-form>
        <!--BOTONES CUANDO SE REALICE LA EDICIÓN-->
        <v-row justify="center" >
          <v-col cols="12" class="py-0 px-0">
            <v-container fluid class="py-0 px-0  ">
              <v-row class="py-0">
                <v-col cols="12" class="py-0">
                  <v-card flat tile class="py-0">
                    <v-card-text class="py-0">


                      <!-- M E N Ú    V E R T I C A L   D A T O S -->
                      <v-tabs vertical>

                        <v-tab class="py-0">
                          <v-icon left>
                            mdi-account
                          </v-icon>
                          EVALUACION DEL PRESTATARIO
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-lock
                          </v-icon>
                          GARANTIA
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-access-point
                          </v-icon>
                          INFORMACION DEL TRAMITE
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-account-arrow-left
                          </v-icon>
                          PERSONA DE REFERENCIA
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-account-check
                          </v-icon>
                          PERSONA CODEUDORA
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-book-open-page-variant
                          </v-icon>
                          DOCUMENTOS PRESENTADOS
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-alert
                          </v-icon>
                          OBSERVACIONES DEL TRAMITE
                        </v-tab>

                        <v-tab>
                          <v-icon left>
                            mdi-monitor-cellphone
                          </v-icon>
                          HISTORIAL DEL TRAMITE
                        </v-tab>


                        <!-- E V A L U A C I Ó N   D E   P R E S T A T A R I O -->
                        <v-tab-item>
                          <v-card flat>
                            <v-card-text>

                              <v-row>
                                <v-col cols="12" md="12" class="py-0">
                                  <p style="color:teal"><b>EVALUACION DEL PRESTATARIO PARA ACCEDER AL PRESTAMO</b></p>
                                </v-col>
                                
                                <v-progress-linear></v-progress-linear>
                                <br>

                                <v-col cols="12" md="4" class="py-0">
                                   <p><b>MONTO SOLICITADO: </b> {{loan.amount_approved | moneyString}} Bs.</p>
                                </v-col>

                                <v-col class="py-0">
                                  <p><b>PLAZO EN MESES:</b>{{' '+loan.loan_term}}</p>
                                </v-col>

                                <v-col cols="12" md="4" class="py-0">
                                   <p><b>PROMEDIO LIQUIDO PAGABLE: </b> {{loan.borrower[0].payable_liquid_calculated | moneyString }} Bs.</p>
                                </v-col>

                                <v-col cols="12" md="4" class="py-0" >
                                   <p><b>LIQUIDO PARA CALIFICACION: </b> {{loan.borrower[0].liquid_qualification_calculated | moneyString}} Bs.</p>
                                </v-col>

                                <v-col cols="12" md="4" class="py-0">
                                   <p><b>TOTAL BONOS:</b> {{loan.borrower[0].bonus_calculated | moneyString}}</p>
                                </v-col>
                                
                                <v-col cols="12" md="4" class="py-0">
                                   <p><b>INDICE DE ENDEUDAMIENTO:</b> {{loan.borrower[0].indebtedness_calculated|percentage }}% </p>
                                </v-col>

                                <v-col cols="12" md="4" class="py-0">
                                   <p><b>CALCULO DE CUOTA: </b> {{loan.estimated_quota | moneyString}} Bs.</p>
                                </v-col>
                              </v-row>

                            </v-card-text>
                          </v-card>
                        </v-tab-item>

                        <!-- S E C C I Ó N   D E   G A R A N T Í A -->
                        <v-tab-item>
                          <v-card flat class=" py-0">
                            <v-card-text  class=" py-0">
                              <v-col cols="12" md="12" color="orange">
                                <v-card-text class="pa-0 mb-0">

                                  <v-col cols="12" md="12" class="py-0 px-0" >
                                    <p style="color:teal"><b>GARANTÍA</b></p>
                                  </v-col>

                                  <v-progress-linear></v-progress-linear>

                                  <div v-for="procedure_type in procedure_types" :key="procedure_type.id" class="pa-0 py-0" >
                                    <ul style="list-style: none" class="pa-0" v-if="procedure_type.name == 'Préstamo a Largo Plazo' || procedure_type.name == 'Préstamo a Corto Plazo'|| procedure_type.name == 'Refinanciamiento Préstamo a Corto Plazo' || procedure_type.name == 'Refinanciamiento Préstamo a Largo Plazo'">
                                      <li v-for="guarantor in loan.borrowerguarantors" :key="guarantor.id">
                                        <v-col cols="12" md="12" class="pa-0">

                                          <v-row class="pa-2">
                                            <v-col cols="12" md="12" class="py-0">
                                              <p style="color:black"><b>GARANTE </b></p>
                                            </v-col>

                                            <v-progress-linear></v-progress-linear><br>

                                            <v-col cols="12" md="3">
                                              <p><b>NOMBRE:</b> {{$options.filters.fullName(guarantor, true)}}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>CÉDULA DE IDENTIDAD:</b> {{guarantor.identity_card +" "+ identityCardExt(guarantor.city_identity_card_id) }}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>TELÉFONO:</b> {{guarantor.cell_phone_number}}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>PORCENTAJE DE PAGO:</b> {{guarantor.pivot.payment_percentage|percentage }}%</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>LIQUIDO PARA CALIFICACION:</b> {{guarantor.pivot.payable_liquid_calculated | moneyString}}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>PROMEDIO DE BONOS:</b> {{guarantor.pivot.bonus_calculated| moneyString }}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>LIQUIDO PARA CALIFICACION CALCULADO:</b> {{guarantor.pivot.liquid_qualification_calculated | moneyString}}</p>
                                            </v-col>

                                            <v-col cols="12" md="3">
                                              <p><b>INDICE DE ENDEUDAMIENTO CALCULADO:</b> {{guarantor.pivot.indebtedness_calculated|percentage }}%</p>
                                            </v-col>
                                          </v-row>

                                        </v-col>
                                      </li>
                                      <br>

                                      <p v-if="loan.guarantors.length==0" ><b> NO TIENE GARANTES </b></p>

                                    </ul>

                                    <v-col cols="12" md="12" v-if="procedure_type.name == 'Préstamo Hipotecario' || procedure_type.name == 'Refinanciamiento Préstamo Hipotecario'">
                                     <p style="color:teal"><b>GARANTIA HIPOTECARIA </b></p>
                                      <v-row>
                                        <v-progress-linear></v-progress-linear><br>

                                        <v-col cols="12" md="4">
                                          <p><b>CIUDAD:</b> {{loan_properties.city_properties}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>UBICACION:</b> {{loan_properties.location}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>NUMERO DE LOTE:</b> {{loan_properties.land_lot_number}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>SUPERFICIE:</b> {{loan_properties.surface}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>UNIDAD DE MEDIDA:</b> {{loan_properties.measurement}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>CODIGO CATASTRAL:</b> {{loan_properties.cadastral_code}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>NRO MATRICULA:</b> {{loan_properties.registration_number}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>NRO FOLIO REAL:</b> {{loan_properties.real_folio_number}}</p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>VNR: </b>{{ loan_properties.net_realizable_value}} </p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                           <p><b>VALOR COMERCIAL: </b>{{loan_properties.commercial_value}} </p>
                                        </v-col>

                                        <v-col cols="12" md="4">
                                          <p><b>VALOR DE RESCATE HIPOTECARIO: </b>{{loan_properties.rescue_value}} </p>
                                        </v-col>
                                      </v-row>
                                    </v-col>

                                    <ul style="list-style: none" class="pa-0 py-0" v-if="procedure_type.name == 'Préstamo Anticipo'">
                                      <v-col cols="12" md="12" class="py-0" >
                                        <p style="color:teal" ><b>GARANTE</b></p>
                                      </v-col>

                                      <v-progress-linear></v-progress-linear>

                                      <br>
                                      <p> <b>NO TIENE GARANTES</b></p>
                                    </ul>

                                  </div>
                                </v-card-text>
                              </v-col>
                            </v-card-text>
                          </v-card>
                        </v-tab-item>



                        </v-tabs>
                    </v-card-text>
                  </v-card>
                 </v-col>
                </v-row>
              </v-container>
            </v-col>
          </v-row>
      </v-form>
  </v-container>
</template>
<script>

import DocumentsFlow from "@/components/tracing/DocumentsFlow"
import ObserverFlow from "@/components/tracing/ObserverFlow"
import HistoryFlow from "@/components/tracing/HistoryFlow"

export default {
  components: {
   DocumentsFlow,
   ObserverFlow,
   HistoryFlow
  },
  name: "specific-data-loan",
  props: {
    loan_refinancing: {
      type: Object,
      required: true
    },
    loan: {
      type: Object,
      required: true
    },
    observations: {
      type: Array,
      required: true
    },
    observation_type: {
      type: Array,
      required: true
    },
    loan_properties: {
      type: Object,
      required: true
    },
    procedure_types: {
      type: Object,
      required: true
    },
  },
   data: () => ({
    items_measurement: [
      { name: "Metros cuadrados", value: "METROS CUADRADOS" },
      { name: "Hectáreas", value: "HECTÁREAS" }
    ],
       headers: [
        {
          text: 'PRIMER NOMBRE',
          align: 'start',
          sortable: false,
          value: 'first_name',
          class: ['normal', 'white--text','text-md-center']
        },
        { text: 'SEGUNDO NOMBRE',  value: 'second_name', class: ['normal', 'white--text','text-md-center'] },
        { text: 'PRIMER APELLIDO ', value: 'last_name', class: ['normal', 'white--text','text-md-center'] },
        { text: 'SEGUNDO APELLIDO ', value: 'mothers_last_name', class: ['normal', 'white--text','text-md-center'] },
        { text: 'TELÉFONO', value: 'phone_number', class: ['normal', 'white--text','text-md-center'] },
        { text: 'CELULAR', value: 'cell_phone_number', class: ['normal', 'white--text','text-md-center'] },
        { text: 'DIRECCION ', value: 'address', class: ['normal', 'white--text','text-md-center'] },
      ],
    city: [],
    entity: [],
    entities:null,
  }),
  beforeMount(){
    this.getCity()
    this.getEntity()
  },
  computed: {
      cuenta() {
       for (this.i = 0; this.i< this.entity.length; this.i++) {
        if(this.loan.lenders[0].financial_entity_id==this.entity[this.i].id)
        {
          this.entities= this.entity[this.i].name
        }
      }
      return this.entities
    }
  },
  methods:{
  //Metodo para obtener la entidad financiera
    async getEntity() {
      try {
        this.loading = true
        let res = await axios.get(`financial_entity`)
        this.entity = res.data
       } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    //Metodo para obtener la ciudad
    async getCity() {
      try {
        this.loading = true
        let res = await axios.get(`city`)
        this.city = res.data
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    //Metodo para obtener la extencion del ci
    identityCardExt(id){
      let ext
      if(id != null){
        for(let i=0; i<this.city.length;i++){
          if(this.city[i].id == id){
            ext = this.city[i].first_shortened
          }
        }
      return ext
      }else{
        return ''
      }
    },
  }
}
</script>
