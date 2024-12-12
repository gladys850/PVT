<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="affiliates"
      :loading="loading"
      :options.sync="options"
      :server-items-length="totalAffiliates"
      :footer-props="{ itemsPerPageOptions: [8, 15, 30] }"
    >
      <template v-slot:item="props">
        <tr>
          <td class="text-xs-left">{{ props.item | fullName(byFirstName = true) }} </td>
          <td class="text-xs-left">{{ props.item.identity_card }}</td>
          <td class="text-xs-left">{{ props.item.affiliate_state ? props.item.affiliate_state.name : ''}}</td>
          <td class="text-xs-left">{{ props.item.category ? props.item.category.name : '' }}</td>

          <td>
            <v-icon class="mr-1" :color="props.item.picture_saved ? 'success' : 'error'">mdi-camera</v-icon>
            <v-icon class="ml-1" :color="props.item.fingerprint_saved ? 'success' : 'error'">mdi-fingerprint</v-icon>
          </td>

          <td >
            <v-btn
              fab
              dark
              x-small
              :to="{ name: 'affiliateAdd', params: { id: props.item.id }}"
              color="warning"
            >
              <v-icon>mdi-eye</v-icon>
            </v-btn>

            <v-btn
              fab
              dark
              x-small
              color="primary"
              @click="openDialog(props.item.id)"
            >
              <v-icon>mdi-printer</v-icon>
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <!-- Modal -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Introducir Código</span>
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="code"
            label="REgistrar HRE"
            required
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn text color="grey" @click="dialog = false">Cerrar</v-btn>
          <v-btn text color="primary" @click="printCertificate">Imprimir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'affiliates-list',
  props: ['bus'],
  data: () => ({
    loading: true,
    search: '',
    options: {
      page: 1,
      itemsPerPage: 8,
      sortBy: ['first_name'],
      sortDesc: [false]
    },
    affiliates: [],
    totalAffiliates: 0,
    headers: [
     
      { 
        text: 'Nombre',
        value: 'first_name', 
        class: ['normal', 'white--text'],
        width: '35%',
        sortable: false 
      },{ 
        text: 'Nro. de CI',
        value: 'identity_card',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false 
      },{
        text: 'Estado',
        value: 'affiliate_state_id',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Categoría',
        value: 'category_id',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      },{
        text: 'Biométrico',
        class: ['normal', 'white--text'],
        width: '15%',
        sortable: false
      },{ 
        text: 'Acción',
        class: ['normal', 'white--text'],
        width: '10%',
        sortable: false
      }    
    ],
    dialog: false,
    selectedAffiliateId: null,
    code: '',
    state: [],
    category:[]
  }),
  watch: {
    options: function(newVal, oldVal) {
      if (
        newVal.page !== oldVal.page ||
        newVal.itemsPerPage !== oldVal.itemsPerPage ||
        newVal.sortBy !== oldVal.sortBy ||
        newVal.sortDesc !== oldVal.sortDesc
      ) {
        this.getAffiliates()
      }
    },
    search: function(newVal, oldVal) {
      if (newVal != oldVal) {
        this.options.page = 1
        this.getAffiliates()
      }
    },
  },
  mounted() {
    this.bus.$on('search', val => {
      this.search = val
    })
    this.getAffiliates()
  },
  methods: {
    async getAffiliates(params) {
      try {
        this.loading = true
        let res = await axios.get(`affiliate`, {
          params: {
            page: this.options.page,
            per_page: this.options.itemsPerPage,
            sortBy: this.options.sortBy,
            sortDesc: this.options.sortDesc,
            search: this.search
          }
        })
        this.affiliates = res.data.data
        this.totalAffiliates = res.data.total
        delete res.data['data']
        this.options.page = res.data.current_page
        this.options.itemsPerPage = parseInt(res.data.per_page)
        this.options.totalItems = res.data.total
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    openDialog(id) {
      this.selectedAffiliateId = id;
      this.dialog = true;
    },
    async printCertificate() {
      let res = await axios.post(`affiliate/${this.selectedAffiliateId}/no_debt_certification`, {
        code: this.code
      });
      printJS({
          printable: res.data.content,
          type: res.data.type,
          file_name: res.data.file_name,
          base64: true
        })
      this.dialog = false;
    },
  },
};
</script>
