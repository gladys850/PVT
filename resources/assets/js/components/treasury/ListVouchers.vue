<template>
  <v-container fluid>
    <ValidationObserver>
      <v-form>
        <v-card flat>
          <v-card-title class="pa-0 pb-3">
            <v-toolbar dense color="tertiary" class="font-weight-regular">
              <v-toolbar-title>Tesorería</v-toolbar-title>
            </v-toolbar>
          </v-card-title>

        <!-- Botón descargar excel -->
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn 
                fab
                @click="download_report()"
                color="success"
                v-on="on"
                x-small
                absolute
                right
                style="margin-right: 40px; margin-top: -50px"
                :loading_download= loading
              >
                <v-icon>mdi-file-excel</v-icon>
              </v-btn>
            </template>
            <span>Descargar reporte</span>
          </v-tooltip>

        <!-- Limpiar filtros -->
          <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-btn
                  fab
                  @click="clearAll()"
                  color="info"
                  v-on="on"
                  x-small
                  absolute
                  right
                  style="margin-right:0px; margin-top: -50px"
                >
                  <v-icon>mdi-broom</v-icon>
                </v-btn>
            </template>
            <span>Limpiar todos los filtros</span>
          </v-tooltip>

          <v-data-table
            :headers="headers"
            :items="vouchers"
            :options.sync="options"
            :server-items-length="totalVouchers"
            :footer-props="{ itemsPerPageOptions: [8, 15, 30] }"
            :loading= loading_table 
          >
          <!-- Headers -->
            <template v-slot:[`header.code_voucher`]="{ header }">
              <span :class="searching.code_voucher? 'primary--text' : ''">{{ header.text }}</span>
            </template>

            <template v-slot:[`header.identity_card_borrower`]="{ header }">
              <span :class="searching.identity_card_borrower? 'primary--text' : ''">{{ header.text }}</span>
            </template>

            <template v-slot:[`header.full_name_borrower`]="{ header }">
              <span :class="searching.full_name_borrower? 'primary--text' : ''">{{ header.text }}</span>
            </template>

            <template v-slot:[`header.code_loan_payment`]="{ header }">
              <span :class="searching.code_loan_payment? 'primary--text' : ''">{{ header.text }}</span>
            </template>}

            <template v-slot:[`header.voucher_type_loan_payment`]="{ header }">
              <span :class="searching.voucher_type_loan_payment? 'primary--text' : ''">{{ header.text }}</span>
            </template>

            <template v-slot:[`header.bank_pay_number_voucher`]="{ header }">
              <span :class="searching.bank_pay_number_voucher? 'primary--text' : ''">{{ header.text }}</span>
            </template>

            <template v-slot:[`header.code_loan`]="{ header }">
              <span :class="searching.code_loan? 'primary--text' : ''">{{ header.text }}</span>
            </template>
          <!-- End Headers -->

          <!-- Máscaras para algunos campos -->
            <template v-slot:[`item.payment_date_voucher`]="{ item }">
              {{ item.payment_date_voucher | date}}
            </template>

            <template v-slot:[`item.voucher_type_loan_payment`]="{ item }">
              {{ item.voucher_type_loan_payment ? item.voucher_type_loan_payment : ''}}
            </template>

            <template v-slot:[`item.total_voucher`]="{ item }">
              {{ item.total_voucher | money}}
            </template>

            <template v-slot:[`item.code_loan_payment`]="{ item }">
              {{ item.code_loan_payment ? item.code_loan_payment : ''}}
            </template>
          <!-- End Máscaras -->
          <!-- Acciones -->
            <template v-slot:[`item.actions`]="{ item }">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    icon
                    small
                    v-on="on"
                    color="warning"
                    :to="{ name: 'paymentAdd',  params: { hash: 'view'},  query: { loan_payment: item.id_loan_payment}}"
                  >
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                </template>
                <span>Ver voucher</span>
              </v-tooltip>

              <v-tooltip bottom v-if="permissionSimpleSelected.includes('delete-voucher-paid')">
                <template v-slot:activator="{ on }">
                  <v-btn
                    icon
                    small
                    v-on="on"
                    color="error"
                    @click.stop="bus.$emit('openRemoveDialog', `voucher/${item.id_voucher}`)"
                  >
                    <v-icon>mdi-file-cancel-outline</v-icon>
                  </v-btn>
                </template>
                <span>Anular voucher</span>
              </v-tooltip>

              <v-menu offset-y close-on-content-click>
                <template v-slot:activator="{ on }">
                  <v-btn icon color="primary" dark v-on="on">
                    <v-icon>mdi-printer</v-icon>
                  </v-btn>
                </template>
                <v-list dense class="py-0">
                  <v-list-item v-for="doc in printDocs" :key="doc.id" @click="imprimir(doc.id, item.id_voucher)">
                    <v-list-item-icon class="ma-0 py-0 pt-2">
                      <v-icon class="ma-0 py-0" small color="light-blue accent-4">{{doc.icon}}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="ma-0 py-0 mt-n2">{{ doc.title }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </template>

          <!-- Filtros -->
            <template slot="body.prepend">
              <tr v-if="show_filter">
                <td><v-text-field placeholder="Cod. Trans" spellcheck="false" class="filter-text" v-model="searching.code_voucher" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field placeholder="CI. Prestatario" spellcheck="false" class="filter-text" v-model="searching.identity_card_borrower" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field placeholder="Nombre completo" spellcheck="false" class="filter-text" v-model="searching.full_name_borrower" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field placeholder="Reg. Cobro" spellcheck="false" class="filter-text" v-model="searching.code_loan_payment" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field disabled class="filter-text"></v-text-field></td>
                <td><v-text-field placeholder="Tipo Pago" spellcheck="false" class="filter-text" v-model="searching.voucher_type_loan_payment" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field placeholder="Nro. dep Bancario" spellcheck="false" class="filter-text" v-model="searching.bank_pay_number_voucher" @keydown.enter="getVouchers()"></v-text-field></td>
                <td><v-text-field disabled class="filter-text"></v-text-field></td>
                <td><v-text-field placeholder="Cod. Préstamo" spellcheck="false" class="filter-text" v-model="searching.code_loan" @keydown.enter="getVouchers()"></v-text-field></td>                
                <td><v-text-field disabled class="filter-text"></v-text-field></td>
              </tr>
            </template>

          </v-data-table>
          <RemoveItem :bus="bus" />
        </v-card>
      </v-form>
    </ValidationObserver>
  </v-container>
</template>

<script>

import RemoveItem from '@/components/shared/RemoveItem'
export default {
  name: 'vouchers-list',
  components: {
    RemoveItem
  },
  data: () => ({
    bus: new Vue(),
    loading: false,
    search: '',
    options: {
      page: 1,
      itemsPerPage: 8,
      sortBy: ['code_voucher'],
      sortDesc: [false]
    },
    vouchers: [],
    totalVouchers: 0,
    searching: {
        code_voucher:"",
        code_loan_payment:"",
        voucher_type_loan_payment:"",
        bank_pay_number_voucher: "",
        full_name_borrower: "",
        identity_card_borrower: "",
        code_loan: "",
    },
    headers: [
     
      { 
        text: 'Código',
        value: 'code_voucher', 
        class: ['normal', 'white--text'],
        width: '15%',
        sortable: false 
      },{
        text: 'CI Prestatario',
        value: 'identity_card_borrower',
        class: ['normal', 'white--text'],
        sortable: false,
        width: '10%'
      },{
        text: 'Nombre Completo Prestatario',
        value: 'full_name_borrower',
        class: ['normal', 'white--text'],
        sortable: false,
        width: '10%'
      },{
        text: 'Registro de cobro',
        value: 'code_loan_payment',
        class: ['normal', 'white--text'],
        width: '15%',
        sortable: false
      },{ 
        text: 'Fecha de pago',
        value: 'payment_date_voucher',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false 
      },{
        text: 'Tipo de pago',
        value: 'voucher_type_loan_payment',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Nro depósito bancario',
        value: 'bank_pay_number_voucher',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Total pagado',
        value: 'total_voucher',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Código Préstamo',
        value: 'code_loan',
        class: ['normal', 'white--text'],
        sortable: false,
        width: '10%'
      },{ 
        text: 'Acción',
        value: "actions",
        class: ['normal', 'white--text'],
        sortable: false,
        width: '10%',
        sortable: false
      },
    ],
    printDocs: [],
    trashed_voucher: false,
    show_filter:true,
    loading_table: false,
  }),
  computed: {
    //Metodo para obtener Permisos por rol
    permissionSimpleSelected() {
      return this.$store.getters.permissionSimpleSelected;
    },
  },
  watch: {
    options: function(newVal, oldVal) {
      if (newVal.page != oldVal.page || newVal.itemsPerPage != oldVal.itemsPerPage || newVal.sortBy != oldVal.sortBy || newVal.sortDesc != oldVal.sortDesc) {
        this.getVouchers()
      }
    },

  },
  mounted() {
    this.bus.$on('removed', val => {
      this.getVouchers()
    })
    this.getVouchers()
    this.docsLoans()
  },
  methods: {
    async imprimir(id, item){
      try {
        let res;
        if(id == 6){
          res = await axios.get(`voucher/${item}/print/voucher`);          
        }
        printJS({
            printable: res.data.content,
            type: res.data.type,
            documentTitle: res.data.file_name,
            base64: true
        })  
      } catch (e) {
        this.toastr.error("Ocurrió un error en la impresión.")
        console.log(e)
      }      
    },
    async getVouchers() {
      this.loading_table = true
      try {
        let res = await axios.get(`index_voucher`, {
          params: {
            code_voucher: this.searching.code_voucher,
            identity_card_borrower: this.searching.identity_card_borrower,
            full_name_borrower: this.searching.full_name_borrower,
            code_loan_payment: this.searching.code_loan_payment,
            voucher_type_loan_payment: this.searching.voucher_type_loan_payment,
            bank_pay_number_voucher: this.searching.bank_pay_number_voucher,
            page: this.options.page,
            per_page: this.options.itemsPerPage,
            sortBy: this.options.sortBy,
            sortDesc: this.options.sortDesc,
            code_loan: this.searching.code_loan,
            trashed_voucher: this.trashed_voucher
          },
        });
        this.vouchers = res.data.data
        this.totalVouchers = res.data.total
        delete res.data["data"]
        this.options.page = res.data.current_page
        this.options.itemsPerPage = parseInt(res.data.per_page)
        this.options.totalItems = res.data.total
        this.loading_table = false
      } catch (e) {
        console.log(e)
        this.loading_table = false
      }
    },
    async download_report() {
      this.loading = true
      await axios({
        url: "/index_voucher",
        method: "GET",
        responseType: "blob",
        headers: { Accept: "application/vnd.ms-excel"},
        params: {
          code_voucher: this.searching.code_voucher,
          identity_card_borrower: this.searching.identity_card_borrower,
          full_name_borrower: this.searching.full_name_borrower,
          code_loan_payment: this.searching.code_loan_payment,
          voucher_type_loan_payment: this.searching.voucher_type_loan_payment,
          bank_pay_number_voucher: this.searching.bank_pay_number_voucher,
          code_loan: this.searching.code_loan,
          excel: true,
          trashed_voucher: this.trashed_vocher
        },
      })
      .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]))
        const link = document.createElement("a")
        link.href = url
        link.setAttribute("download", "ReporteTesoreria.xls")
        document.body.appendChild(link)
        link.click()
      })
      .catch((error) => {
        console.log(error)
        this.loading = false
      })
      this.loading = false
    },
    clearAll() {
      this.searching.code_voucher = "",
      this.searching.identity_card_borrower = "",
      this.searching.full_name_borrower = "",
      this.searching.code_loan_payment = "",
      this.searching.voucher_type_loan_payment = "",
      this.searching.bank_pay_number_voucher = "",
      this.searching.code_loan = "",
      this.getVouchers()
    },

        docsLoans() {
      let docs = [];
      if (this.permissionSimpleSelected.includes("print-payment-voucher")) {
        docs.push({ id: 6, title: "Registro de pago", icon: "mdi-cash-multiple" });
      } else {
        console.log("Se ha producido un error durante la generación de la impresión");
      }
      this.printDocs = docs;
      console.log(this.printDocs);
    },
    _show_filter(){
       this.show_filter=!this.show_filter
    }
  },
}
</script>
<style scoped>
.v-text-field {
  background-color: white;
  width: 200px;
  padding: 5px;
  margin: 0px;
  font-size: 0.8em;
  border-color: teal;
}
.filter-text{
  font-size: 12px;
  height: 2px;
  margin: 0 0 40px 0;
  padding: 0;
  width: 100%

}
</style>
