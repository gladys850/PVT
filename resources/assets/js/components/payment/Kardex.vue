<template>
  <v-container fluid>
    <v-toolbar-title class="pb-2 ma-0 pa-0">KARDEX</v-toolbar-title>
    <template v-if="removeAccents(loan.disbursement_date) != 'Fecha invalida'">

      <!-- B O T Ó N   N U E V O   R E G I S T R O   C O B R O -->
      <v-tooltip top v-if="permissionSimpleSelected.includes('create-payment-loan')">
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            dark
            x-small
            :color="'success'"
            top
            left
            absolute
            v-on="on"
            style="margin-left: 100px; margin-top: 20px"
            :disabled="loan.state.name == 'Liquidado' ? true : false"
            @click="createPayment()"
          >
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Nuevo registro de cobro</span>
        </div>
      </v-tooltip>

      <!-- B O T Ó N  I M P R I M I R  P L A N  D E  P A G O S -->
      <v-tooltip top v-if="permissionSimpleSelected.includes('print-payment-plan')">
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="info"
            top
            left
            absolute
            v-on="on"
            style="margin-left: 150px; margin-top: 20px"
            @click="imprimirPlan($route.params.id)"
          >
            <v-icon>mdi-printer</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Imprimir Plan de Pagos</span>
        </div>
      </v-tooltip>

      <!-- B O T Ó N  I M P R I M I R  K A R D E X -->
      <v-tooltip top v-if="permissionSimpleSelected.includes('print-payment-kardex-loan')">
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="dark"
            top
            left
            absolute
            v-on="on"
            style="margin-left: 200px; margin-top: 20px"
            @click="imprimirK($route.params.id, true)"
          >
            <v-icon>mdi-printer</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Imprimir Kardex</span>
        </div>
      </v-tooltip>

      <!-- B O T Ó N  I M P R I M I R  K A R D E X  D E S P L E G A D O -->
      <v-tooltip top v-if="permissionSimpleSelected.includes('print-payment-kardex-loan')">
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="blue lighten-4"
            top
            left
            absolute
            v-on="on"
            style="margin-left: 250px; margin-top: 20px"
            @click="imprimirK($route.params.id, false)"
          >
            <v-icon>mdi-printer</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Imprimir Kardex desplegado</span>
        </div>
      </v-tooltip>
            <!-- B O T Ó N  I M P R I M I R  C E R T I F I C A D O  D E  D E V O L U C I Ó N  A  G A R A N T E -->
      <v-tooltip top v-if="permissionSimpleSelected.includes('print-loan-certification') && loan.guarantors.length>0">
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="danger"
            top
            left
            absolute
            v-on="on"
            style="margin-left: 300px; margin-top: 20px"
            @click="dialog_guarantor_certification = true"
          >
            <v-icon color="white">mdi-printer-check</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Imprimir Certificado de descuento por garantia</span>
        </div>
      </v-tooltip>

      <v-dialog
        v-model="dialog_guarantor_certification"
        max-width="550"
      >
        <v-card>
          <v-card-title>
            Se realizará la generación de certificacion de:
            <div v-for="guarantor in loan.borrowerguarantors" :key="guarantor.id">
              <div>
                <v-row class="pt-2">
                  <v-col cols="2">
                    <v-checkbox
                      class="ma-0 pa-0"
                      color="success"
                      v-model="selected_guarantor"
                      :value="guarantor.affiliate_id"
                    ></v-checkbox>
                  </v-col>
                  <v-col cols="10" class="ma-0 body-1">
                    {{$options.filters.fullName(guarantor, true)}}
                  </v-col>
                </v-row>
              </div>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="red darken-1"
              text
              @click="dialog_guarantor_certification = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="green darken-1"
              text
              @click.stop="printWarrantyDiscountCertification($route.params.id)"
            >
              Aceptar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- S E C C I Ó N  D A T O S  B O R R O W E R  Y  L O A N -->
      <v-card class="ma-0 pa-0 pb-2">
        <v-row class="ma-0 pa-0">
          <v-col md="4" class="ma-0 pa-0">
            <strong>Prestatario: </strong> {{ borrower.type == 'spouses' ? $options.filters.fullName(spouse, true) : $options.filters.fullName(affiliate, true)  }}<br />
            <strong>CI: </strong> {{ borrower.type == 'spouses' ? spouse.identity_card : affiliate.identity_card  }}<br />
            <strong>Matrícula: </strong> {{ borrower.type == 'spouses' ?  spouse.registration : affiliate.registration }}<br />
            <strong>Cuotas: </strong> {{ payments.length ? payments.length : ""}}<br />
          </v-col>
          <v-col md="4" class="ma-0 pa-0">
            <strong>Desembolso: </strong>{{ loan.disbursement_date | datetimeshorted }}<br />
            <strong>Nro de comprobante contable: </strong>{{ loan.num_accounting_voucher }}<br />
            <strong>Tasa anual: </strong> {{ loan.intereses.annual_interest | percentage }}%<br />
            <strong>Cuota fija mensual: </strong> {{ loan.estimated_quota | moneyString}}<br />
          </v-col>
          <v-col md="4" class="ma-0 pa-0">
            <strong>Monto desembolsado: </strong>{{ loan.amount_approved | moneyString }}<br />
            <strong>Saldo Capital: </strong>{{ loan.balance | moneyString }}<br />
            <strong>Intereses Corrientes Pendientes: </strong>{{(payments[payments.length - 1] ? payments[payments.length - 1].interest_accumulated : 0) | moneyString }}<br />
            <strong>Intereses Penales Pendientes: </strong>{{ payments[payments.length - 1] ? payments[payments.length - 1].penal_accumulated : 0 | moneyString }}
           </v-col>
        </v-row>
      </v-card>

      <!-- S E C C I Ó N  T A B L A  D E  P A G O S -->
      <v-data-table
        dense
        :headers="headers"
        :items="payments"
        :loading="loading"
        :options.sync="options"
        :footer-props="{ itemsPerPageOptions: [10,50,100] }"
        :search="search"
        :key="refreshKardexTable"
      >

        <template v-slot:[`header.code`]="{ header }">
            {{ header.text }}<br>
            <v-menu offset-y :close-on-content-click="false">
              <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on">
                  <v-icon small :color="search !='' ? 'red' : 'black'">
                    mdi-filter
                  </v-icon>
                </v-btn>
              </template>
              <div>
                <v-text-field
                  dense
                  v-model="search"
                  type="text"
                  :label="'Buscar ' + header.text"
                  hide-details
                  single-line
                ></v-text-field>
              </div>
            </v-menu>
          </template>

        <template v-slot:[`item.estimated_date`]="{ item }">
          {{ item.estimated_date | date }}
        </template>
        <template v-slot:[`item.created_at`]="{ item }">
          {{ item.created_at | date }}
        </template>
        <template v-slot:[`item.capital_payment`]="{ item }">
          {{ item.capital_payment | moneyString }}
        </template>
                <template v-slot:[`item.interest_payment`]="{ item }">
          {{ item.interest_payment | moneyString }}
        </template>
                <template v-slot:[`item.interest_remaining`]="{ item }">
          {{ item.interest_remaining | moneyString }}
        </template>
                <template v-slot:[`item.penal_payment`]="{ item }">
          {{ item.penal_payment | moneyString }}
        </template>
        <template v-slot:[`item.penal_remaining`]="{ item }">
          {{ item.penal_remaining | moneyString }}
        </template>
        <template v-slot:[`item.estimated_quota`]="{ item }">
          {{ item.estimated_quota | moneyString }}
        </template>
        <template v-slot:[`item.voucher`]="{ item }">
          {{item.voucher}}
        </template>
        <template v-slot:[`item.modality_shortened`]="{ item }">
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <span v-on="on"> {{item.modality.shortened}}</span>
            </template>
            <span>{{item.modality.name}}</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.state_name`]="{ item }">
          {{ item.state.name }}
        </template>
        <template v-slot:[`item.voucher_treasury_code`]="{ item }">
          {{ item.voucher_treasury != null ? item.voucher_treasury.code : ''}}
        </template>
        <template v-slot:[`item.paid_by`]="{ item }">
          {{item.paid_by}}-{{item.initial_affiliate}}
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                small
                v-on="on"
                color="warning"
                :to="{
                  name: 'paymentAdd',
                  params: { hash: 'view' },
                  query: { loan_payment: item.id } }">
                <v-icon>mdi-eye</v-icon>
              </v-btn>
            </template>
            <span>Ver registro de cobro</span>
          </v-tooltip>

          <v-tooltip top bottom v-if="permissionSimpleSelected.includes('update-payment-loan')"
          >
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                small
                v-on="on"
                color="success"
                v-if="item.state.name != 'Pagado'"
                :to="{
                  name: 'paymentAdd',
                  params: { hash: 'edit' },
                  query: { loan_payment: item.id },
                }"
              >
                <v-icon>mdi-file-document-edit-outline</v-icon>
              </v-btn>
            </template>
            <span>Editar/Validar registro de cobro</span>
          </v-tooltip>

          <v-tooltip bottom v-if="permissionSimpleSelected.includes('delete-payment-loan')">
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                small
                v-on="on"
                color="error"
                v-if="item.is_last_payment_kardex"
                @click.stop="bus.$emit('openRemoveDialog', `delete_last_payment/${item.id}/payment`)"
              >
                <v-icon>mdi-file-cancel-outline</v-icon>
              </v-btn>
            </template>
            <span>Anular registro de cobro</span>
          </v-tooltip>

          <v-menu offset-y close-on-content-click>
            <template v-slot:activator="{ on }">
              <v-btn icon color="primary" dark v-on="on">
                <v-icon>mdi-printer</v-icon>
              </v-btn>
            </template>
            <v-list dense class="py-0">
              <v-list-item
                v-for="doc in printDocs"
                :key="doc.id"
                @click="imprimir(doc.id, item.id)"
              >
                <v-list-item-icon class="ma-0 py-0 pt-2">
                  <v-icon
                    class="ma-0 py-0"
                    small
                    color="light-blue accent-4"
                  >{{doc.icon}}</v-icon>
                </v-list-item-icon>
                <v-list-item-title class="ma-0 py-0 mt-n2">{{doc.title}}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
          <template></template>
        </template>
      </v-data-table>
      <RemoveItem :bus="bus" />
    </template>
    <template v-else>
      <h3>NO SE CUENTA AÚN CON EL KARDEX</h3>
    </template>
  </v-container>
</template>
<script>
import RemoveItem from "@/components/shared/RemoveItem"
import common from "@/plugins/common"

export default {
  name: "Kardex-list",
  components: {
    RemoveItem,
  },
  props: {
    affiliate: {
      type: Object,
      required: true,
    },
    borrower: {
      type: Object,
      required: true,
    },
    loan: {
      type: Object,
      required: true,
    },
    spouse: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    bus: new Vue(),
    loading: true,
    options: {
      page: 1,
      itemsPerPage: 10,
      sortBy: ["quota_number"],
      sortDesc: [false],
    },
    payments: [],
    totalPayments: 0,
    paymentState: 0,
    printDocs: [],
    amortization_type: [],
    procedure_modality: [],
    search: '',

    headers: [
      {
        text: "Nro Cuota",
        value: "quota_number",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      ,
      {
        text: "Código",
        value: "code",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
      },
      {
        text: "Fecha de cálculo",
        value: "estimated_date",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Fecha de cobro",
        value: "created_at",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Amortización capital",
        value: "capital_payment",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Interes corriente",
        value: "interest_payment",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Interes penal",
        value: "penal_payment",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Interes corriente pendiente",
        value: "interest_remaining",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Interes penal pendiente",
        value: "penal_remaining",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Total pagado",
        value: "estimated_quota",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Comprobante",
        value: "voucher",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Código de Transacción",
        value: "voucher_treasury_code",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Tipo de Amortización.",
        value: "modality_shortened",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "5%",
        filterable: false,
      },
      {
        text: "Pagado por",
        value: "paid_by",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Estado",
        value: "state_name",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Acciones",
        value: "actions",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "15%",
        filterable: false,
      },
    ],
    refreshKardexTable: 0,
    refreshKardexButton: 0,
    dialog_guarantor_certification: false,
    selected_guarantor: [],
  }),
  computed: {
    //Metodo para obtener Permisos por rol
    permissionSimpleSelected() {
      return this.$store.getters.permissionSimpleSelected;
    },
    rolePermissionSelected () {
      return this.$store.getters.rolePermissionSelected
    },
  },
  watch: {
    options: function (newVal, oldVal) {
      if (
        newVal.page != oldVal.page ||
        newVal.itemsPerPage != oldVal.itemsPerPage ||
        newVal.sortBy != oldVal.sortBy ||
        newVal.sortDesc != oldVal.sortDesc
      ) {
        this.getPayments();
      }
    },

  },

  created(){
    this.removeAccents = common.removeAccents
  },
  mounted() {
  this.bus.$on('removed', val => {
      this.getPayments()
    })
    this.getPayments()
  },
  methods: {
    async getPayments() {
      try {
        this.loading = true;
        let res = await axios.get(`kardex_loan_payment`, {
          params: {
            loan_id: this.$route.params.id,
          },
        });
        this.payments = res.data.payments
        if(this.payments.length > 0){
          this.docsLoans()
        }
        this.refreshKardexTable++
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    createPayment(){
      if(this.loan.state.name != 'Liquidado'){
        if(this.loan.balance > 0){
          this.$router.push({ name: 'paymentAdd', params: { hash: 'new' }, query: { loan_id: this.$route.params.id } })
        }else{
          this.toastr.error("El saldo es 0, no puede realizar mas pagos.")
        }
      }
      else {
        this.toastr.error("El trámite tiene estado LIQUIDADO, no puede realizar mas pagos.")
      }
    },

    async imprimir(id, item) {
      try {
        let res;
        if (id == 5) {
          res = await axios.get(`loan_payment/${item}/print/loan_payment`);
        }
        printJS({
          printable: res.data.content,
          type: res.data.type,
          documentTitle: res.data.file_name,
          base64: true,
        });
      } catch (e) {
        this.toastr.error("Ocurrió un error en la impresión.");
        console.log(e);
      }
    },

    docsLoans() {
      let docs = [];
      if (this.permissionSimpleSelected.includes("print-payment-loan")) {
        docs.push({
          id: 5,
          title: "Registro de cobro",
          icon: "mdi-file-check-outline",
        });
      } else {
        console.log("Se ha producido un error durante la generación de la impresión");
      }
      this.printDocs = docs;
    },

    async imprimirK(item, folded) {
      try {
        let res = await axios.get(`loan/${item}/print/kardex`, {
          params: {
            folded: folded,
          },
        });
        printJS({
          printable: res.data.content,
          type: res.data.type,
          file_name: res.data.file_name,
          base64: true,
        });
      } catch (e) {
        this.toastr.error("Ocurrió un error en la impresión.");
        console.log(e);
      }
    },

    async imprimirPlan(item) {
      try {
        let res = await axios.get(`loan/${item}/print/plan`);
        printJS({
          printable: res.data.content,
          type: res.data.type,
          file_name: res.data.file_name,
          base64: true,
        });
      } catch (e) {
        this.toastr.error("Ocurrió un error en la impresión.");
        console.log(e);
      }
    },

    async printWarrantyDiscountCertification(item) {
      try {
        if(this.selected_guarantor>0){
          let res = await axios.get(`loan/${item}/print/loan_certification`, {
          params: {
            guarantors: this.selected_guarantor
          },
        });
        printJS({
          printable: res.data.content,
          type: res.data.type,
          file_name: res.data.file_name,
          base64: true,
        });
        this.dialog_guarantor_certification= false
        }else{
          this.toastr.error("Selecciones un garante para generar la certificación")
        }
      } catch (e) {
        this.toastr.error("Ocurrió un error en la impresión.");
        this.dialog_guarantor_certification = false
        console.log(e);
      }
    },

    /*Obtener ultimo pago desde front
    last_payment(item){
      if(item.id == this.payments[this.payments.length -1].id ){
        return true
      }else{
        return false
      }
    },*/

  },
};
</script>
<style scoped>
.theme--light.v-datatable.v-datatable-tr.v-datatable-td {
  position: fixed;
  bottom: 0;
  padding: 0px;
}
.v-text-field{
  background-color: white;
  width: 200px;
  padding:5px;
  margin: 0px;
  font-size: 0.8em;
  border-color: palegreen;
}
</style>
