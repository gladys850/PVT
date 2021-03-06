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
          <v-data-table
            :headers="headers"
            :items="vouchers"
            :loading="loading"
            :options.sync="options"
            :server-items-length="totalVouchers"
            :footer-props="{ itemsPerPageOptions: [8, 15, 30] }"
          >
            <template v-slot:[`item.payment_date`]="{ item }">
              {{ item.payment_date | date}}
            </template>
                <template v-slot:[`item.voucher_type_name`]="{ item }">
              {{ item.voucher_type ? item.voucher_type.name : ''}}
            </template>
                <template v-slot:[`item.total`]="{ item }">
              {{ item.total | money}}
            </template>
                <template v-slot:[`item.payable_code`]="{ item }">
              {{ item.payable ? item.payable.code : ''}}
            </template>

            <template v-slot:[`item.actions`]="{ item }">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    icon
                    small
                    v-on="on"
                    color="warning"
                    :to="{ name: 'paymentAdd',  params: { hash: 'view'},  query: { loan_payment: item.payable_id}}"
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
                    @click.stop="bus.$emit('openRemoveDialog', `voucher/${item.id}`)"
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
                  <v-list-item v-for="doc in printDocs" :key="doc.id" @click="imprimir(doc.id, item.id)">
                    <v-list-item-icon class="ma-0 py-0 pt-2">
                      <v-icon class="ma-0 py-0" small v-text="doc.icon" color="light-blue accent-4"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="ma-0 py-0 mt-n2">{{ doc.title }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
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
    loading: true,
    search: '',
    options: {
      page: 1,
      itemsPerPage: 8,
      sortBy: ['code'],
      sortDesc: [false]
    },
    vouchers: [],
    totalVouchers: 0,
    headers: [
     
      { 
        text: 'Código',
        value: 'code', 
        class: ['normal', 'white--text'],
        width: '15%',
        sortable: false 
      },
      {
        text: 'Registro de cobro',
        value: 'payable_code',
        class: ['normal', 'white--text'],
        width: '15%',
        sortable: false
      },{ 
        text: 'Fecha de pago',
        value: 'payment_date',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false 
      },{
        text: 'Tipo de pago',
        value: 'voucher_type_name',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Nro depósito bancario',
        value: 'bank_pay_number',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Total pagado',
        value: 'total',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{ 
        text: 'Acción',
        value: "actions",
        class: ['normal', 'white--text'],
        sortable: false,
        width: '10%',
        sortable: false
      }    
    ],
    state: [],
    category:[],
    printDocs: []

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
    async getVouchers(params) {
      try {
        this.loading = true
        let res = await axios.get(`voucher`, {
          params: {
            page: this.options.page,
            per_page: this.options.itemsPerPage,
            sortBy: this.options.sortBy,
            sortDesc: this.options.sortDesc,
            search: this.search
          }
        })
        this.vouchers = res.data.data
        this.totalVouchers = res.data.total
        delete res.data['data']
        this.options.page = res.data.current_page
        this.options.itemsPerPage = parseInt(res.data.per_page)
        this.options.totalItems = res.data.total
      } catch (e) {
        console.log(e)
      } finally {
        this.loading = false
      }
    },
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

        docsLoans() {
      let docs = [];
      if (this.permissionSimpleSelected.includes("print-payment-voucher")) {
        docs.push({ id: 6, title: "Registro de pago", icon: "mdi-cash-multiple" });
      } else {
        console.log("Se ha producido un error durante la generación de la impresión");
      }
      this.printDocs = docs;
      console.log(this.printDocs);
    }


  }
}
</script>

