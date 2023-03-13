<<template>
  <div>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headersHist"
          :items="record"
          class="elevation-1"
          :options.sync="options"
          :server-items-length="options.totalItems"
          :footer-props="{ itemsPerPageOptions: [8, 15, 30, 100] }"
          :loading="loading"
        >
          <template v-slot:item="items">
            <tr>
              <td>{{ items.item.created_at | datetime }}</td>
              <td>{{ items.item.updated_at | datetime }}</td>
              <td>{{ items.item.action }}</td>
            </tr>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  name: "history-flow",
  data: () => ({
    loading: false,
    headersHist: [
      {
        text: "Fecha creación",
        class: ["normal", "white--text"],
        align: "left",
        value: "created_at"
      },
      {
        text: "Fecha actualización",
        class: ["normal", "white--text"],
        align: "left",
        value: "update_at"
      },
      {
        text: "Acciones realizadas",
        class: ["normal", "white--text"],
        align: "left",
        value: "accion"
      }
    ],
    record: [],
    options: {
      page: 1,
      itemsPerPage: 8,
      sortBy: ['created_at'],
      sortDesc: [false]
    },
  }),
  props: {
    affiliate: {
      type: Object,
      required: true
    },
  },
  watch: {
    options: function(newVal, oldVal) {
      if (newVal.page != oldVal.page || newVal.itemsPerPage != oldVal.itemsPerPage || newVal.sortBy != oldVal.sortBy || newVal.sortDesc != oldVal.sortDesc) {
        this.getRecordAffilate(this.affiliate.id)
      }
    },
  },
  mounted() {
    this.getRecordAffilate(this.affiliate.id)
  },
  methods: {
    //Metodo para obtener el record
    async getRecordAffilate(id) {
      try {
        this.loading = true
        let res = await axios.get(`record_affiliate_history`, {
          params: {
            affiliate_id: id,
            page: this.options.page,
            per_page: this.options.itemsPerPage,
            sortBy: this.options.sortBy,
            sortDesc: this.options.sortDesc,
          }
        })
        this.record = res.data.data
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
  }
}
</script>