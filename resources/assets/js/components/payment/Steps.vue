<template>
  <div>
    <v-stepper v-model="e1" >
      <v-stepper-header class=" !pa-0 ml-0" >
        <template>
          <v-stepper-step
            :key="`${1}-step`"
            :complete="e1 > 1"
            :step="1">Creación Amortización
          </v-stepper-step>
          <v-divider v-if="1 !== steps" :key="1" ></v-divider>

         </template>
      </v-stepper-header>
      <v-stepper-items>
        <v-stepper-content :key="`${1}-content`" :step="1">
          <v-card color="grey lighten-1">
            <AddAmortization
            :data_payment.sync="data_payment"
             :payment.sync="payment"/>
            <v-container class="py-0">
              <v-row>
                <v-spacer></v-spacer> <v-spacer></v-spacer> <v-spacer></v-spacer><v-spacer></v-spacer>
                <v-col class="py-0">
                  <v-btn color="seccundary"
                    @click="atras()"  v-show="!isNew">
                    Atras
                  </v-btn>
                  <v-btn
                    color="primary"
                    @click="validatedStepOne()" v-show="!ver">
                    Guardar
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-card>
        </v-stepper-content>
     
     
      </v-stepper-items>
    </v-stepper>
  </div>
</template>
<style >
.v-expansion-panel-content__wrap {
    padding: 0 0px 0px;
}
.v-stepper__content {
    padding: 0px 0px 0px;
}
</style>
<script>
import AddAmortization from '@/components/payment/AddAmortization'
import AddPayment from '@/components/payment/AddPayment'

export default {
  name: "payment-steps",
  props: {
    loan: {
      type: Object,
      required: true
    }
  },
  components: {
    AddAmortization,
    AddPayment
  },
   data: () => ({
    bus: new Vue(),
    e1: 1,
    steps: 2,
    payment:{
      estimated_days:{
        penal:null
      }
    },
    status_click:false,
    data_payment:{
      payment_date:new Date().toISOString().substr(0, 10),
      voucher_date:new Date().toISOString().substr(0, 10),
      pago_total: null,
      voucher:'REGISTRO MANUAL'
  
      
    },
     garantes:{
      lenders:[]
    },
    validar:false,
  }),
  computed: {
    //Metodo para obtener Permisos por rol
    permissionSimpleSelected () {
      return this.$store.getters.permissionSimpleSelected
    },
    isNew() {
      return this.$route.params.hash == 'new'
    },
    ver(){
       return  this.$route.params.hash == 'view'
    },
    editar(){
       return  this.$route.params.hash == 'edit'
    },
  },
  watch: {
    steps (val) {
      if (this.e1 > val) {
        this.e1 = val
      }
    },
  },
  mounted() {
  /*  if(this.$route.params.hash == 'edit')
    {
      this.getLoanPayment(this.$route.query.loan_payment)
    }
     if(this.$route.params.hash == 'view')
    {
      this.getLoanPayment(this.$route.query.loan_payment)
    }*/
  },
  methods: {
    atras(){
       try {
        this.loading = true
        this.$router.push('/loanPayment')
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    nextStep (n) {
      if (n == this.steps) {
        this.e1 = 1
      }
      else {
        this.e1 = n + 1
     }
    },
    beforeStep (n) {
      this.e1 = n -1
    },
    //Metodo para el creado del voucher
      async savePaymentTreasury() {
      try {
            let res1 = await axios.patch(`loan_payment/${this.$route.query.loan_payment}`,{
            validated:true
          })
          let res = await axios.post(`loan_payment/${this.$route.query.loan_payment}/voucher`,{

            voucher_type_id: this.data_payment.tipo_pago,
            bank_pay_number: this.data_payment.comprobante,
            voucher_amount_total:this.data_payment.voucher_amount_total,
            voucher_payment_date: this.data_payment.voucher_date,
            description: this.data_payment.glosa_voucher
          })
          printJS({
            printable: res.data.attachment.content,
            type: res.data.attachment.type,
            base64: true
          })
            this.$router.push('/loanPayment')
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Validar Pago
      async validatePayment() {
      try {
            let res1 = await axios.patch(`loan_payment/${this.$route.query.loan_payment}`,{
            validated:this.data_payment.validated,
            description:this.data_payment.glosa,
            voucher:this.data_payment.voucher
          })
          this.toastr.success('Se editar correctamente')
            this.$router.push('/loanPayment')
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Editar pago
     async editPayment() {
      try {
            let res1 = await axios.patch(`loan_payment/${this.$route.query.loan_payment}`,{
              description:this.data_payment.glosa,
              voucher:this.data_payment.voucher
          })
          this.toastr.success('Se edito correctamente')
            this.$router.push('/loanPayment')
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    //Metodo para crear el Pago
    async savePayment(){
      try {
          this.status_click = true
          if(this.status_click==true)
          {

            let res = await axios.post(`loan/${this.$route.query.loan_id}/payment`,{
            estimated_date:this.data_payment.payment_date,
            estimated_quota:this.data_payment.pago_total,
            voucher:this.data_payment.voucher,
            amortization_type_id:this.data_payment.pago,
            affiliate_id:this.data_payment.affiliate_id_paid_by,
            paid_by:this.data_payment.affiliate_id,
            procedure_modality_id:this.data_payment.procedure_modality_id,
            user_id: this.$store.getters.id,
            state: this.data_payment.refinanciamiento,
            description:this.data_payment.glosa,
            liquidate : this.data_payment.liquidate,
            categorie_id:this.data_payment.categori_id
          })
             if(res.status==201 || res.status == 200){
              this.status_click = false
            }
            printJS({
            printable: res.data.attachment.content,
            type: res.data.attachment.type,
            base64: true
          })
          this.$router.push({ name: 'flowAdd',  params: { id: this.$route.query.loan_id, workTray: 'received'}, query:{ redirectTab: 6 } })
          this.payment = res.data
        }
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }

    },
     //Metodo para sacar datos del pago
     async getLoanPayment(id) {
      try {
        this.loading = true
        let res = await axios.get(`loan_payment/${id}`)
        this.loan_payment = res.data
          this.garantes.lenders=this.loan_payment.affiliate
    
        this.data_payment.code=this.loan_payment.code
        this.data_payment.payment_date= this.loan_payment.estimated_date
        this.data_payment.pago_total=this.loan_payment.estimated_quota
        this.data_payment.affiliate_id =this.loan_payment.paid_by
        this.data_payment.voucher=this.loan_payment.voucher
        this.data_payment.pago  =this.loan_payment.amortization_type_id
        this.data_payment.loan_id  =this.loan_payment.loan_id
        this.data_payment.validated =this.loan_payment.validated
        this.data_payment.glosa =this.loan_payment.description
        this.data_payment.procedure_modality_name =this.loan_payment.modality.procedure_type.name
        this.data_payment.procedure_id= this.loan_payment.procedure_modality_id
        this.data_payment.amortization=2
        if(this.data_payment.procedure_modality_name == 'Amortización Complemento Económico' ||
            this.data_payment.procedure_modality_name == 'Amortización Fondo de Retiro' ||
            this.data_payment.procedure_modality_name == 'Amortización por Ajuste' ||
            this.data_payment.procedure_modality_name == 'Amortización Automática')
          {
            this.data_payment.validar =true
          }else{
            if(this.data_payment.procedure_modality_name == 'Amortización Directa')
            {
              this.data_payment.validar =false
            }
          }
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
    //Metodo para editar el pago
   /* async editLoanPayment(id) {
      try {
        this.loading = true
        let res = await axios.patch(`loan_payment/${id}`,{
        })
        this.loan_payment = res.data
        this.data_payment.code=this.loan_payment.code
        this.data_payment.payment_date= this.loan_payment.estimated_date
        this.data_payment.pago_total=this.loan_payment.estimated_quota
        this.data_payment.affiliate_id =this.loan_payment.paid_by
        this.data_payment.voucher=this.loan_payment.voucher
        this.data_payment.pago  =this.loan_payment.amortization_type_id
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },*/
    //Metodo calculo de siguiente cuota
    async Calcular(id) {
      try {
          let res = await axios.patch(`loan/${id}/payment`,{
            affiliate_id:this.data_payment.affiliate_id_paid_by,
            estimated_date:this.data_payment.payment_date,
            estimated_quota:this.data_payment.pago_total,
            liquidate : this.data_payment.liquidate,
            procedure_modality_id:this.data_payment.procedure_modality_id,
            categorie_id :this.data_payment.categori_id
          })
            this.payment = res.data
            this.data_payment.pago_total=this.payment.estimated_quota
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    async validatedStepTwo()
    {
      try {
        if(this.isNew)
          {
            this.savePayment()
          }
          else{
            if(this.editar)
            {
              this.toastr.error("No tiene los permisos")
            }
          }
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    },
    async validatedStepOne() {
      try {
           if(!this.isNew)
          {
            if(this.data_payment.procedure_modality_name == 'Amortización Complemento Económico' ||
              this.data_payment.procedure_modality_name == 'Amortización Fondo de Retiro' ||
              this.data_payment.procedure_modality_name == 'Amortización por Ajuste' ||
              this.data_payment.procedure_modality_name == 'Amortización Automática')
            {
              this.validatePayment()
            }else{
              if(this.data_payment.procedure_modality_name == 'Amortización Directa' && this.permissionSimpleSelected.includes('create-payment') )
              {
                this.savePaymentTreasury()
              }else{
                this.editPayment()
              }
            }
          }
          else{
            this.validatedStepTwo()
          }
      }catch (e) {
        console.log(e)
      }finally {
        this.loading = false
      }
    }
  },
}
</script>