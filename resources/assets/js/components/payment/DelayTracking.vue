<template>
  <v-container fluid>
    <template v-if="removeAccents(loan.disbursement_date) != 'Fecha invalida'">
      <v-card class="ma-0 pa-0 pb-2">
        <v-row class="ma-0 pa-0">
          <v-col md="4" class="ma-0 pa-0">
            <strong>Prestatario: </strong>
            {{
              borrower.type == "affiliate"
                ? $options.filters.fullName(affiliate, true)
                : $options.filters.fullName(borrower, true)
            }}<br />
            <strong>CI: </strong>
            {{
              borrower.type == "affiliate"
                ? affiliate.identity_card
                : borrower.identity_card
            }}<br />
            <strong>Matrícula: </strong>
            {{
              borrower == "affiliate"
                ? affiliate.registration
                : borrower.registration
            }}<br />

            <strong>Monto desembolsado: </strong
            >{{ loan.amount_approved | moneyString }}<br />
          </v-col>
          <v-col md="4" class="ma-0 pa-0">
            <strong>Desembolso: </strong>{{ loan.disbursement_date | date
            }}<br />
            <strong>Nro de comprobante contable: </strong
            >{{ loan.num_accounting_voucher }}<br />
            <strong>Tasa anual: </strong>
            {{ loan.intereses.annual_interest | percentage }}%<br />
            <strong>Cuota fija mensual: </strong>
            {{ loan.estimated_quota | money }}<br />
          </v-col>
        </v-row>
      </v-card>
      <v-tooltip
        top
        v-if="permissionSimpleSelected.includes('print-delay-tracking')"
      >
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="success"
            @click.stop="dialog = true"
            v-on="on"
            top
            right
            absolute
            style="margin-right: 120px; margin-top: 110px"
          >
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Crear seguimiento de mora de préstamo</span>
        </div>
      </v-tooltip>
      <v-tooltip
        top
        v-if="permissionSimpleSelected.includes('print-delay-tracking')"
      >
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            x-small
            color="info"
            top
            right
            absolute
            v-on="on"
            style="margin-right: 80px; margin-top: 110px"
            @click="printDelayTracking($route.params.id)"
          >
            <v-icon>mdi-printer</v-icon>
          </v-btn>
        </template>
        <div>
          <span>Imprimir seguimiento mora</span>
        </div>
      </v-tooltip>
      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            @click="trashed_delay = !trashed_delay"
            :color="!trashed_delay ? 'error' : 'primary'"
            v-on="on"
            x-small
            top
            right
            absolute
            style="margin-right: 40px; margin-top: 110px"
          >
            <v-icon>{{
              !trashed_delay ? "mdi-file-cancel" : "mdi-file-multiple"
            }}</v-icon>
          </v-btn>
        </template>
        <span v-if="!trashed_delay"
          >Ver registros anulados de seguimiento de mora</span
        >
        <span v-else>Ver registros de seguimiento de mora</span>
      </v-tooltip>
      <v-data-table
        :headers="headers"
        :items="tracking_delays"
        sort-by="id"
        :options.sync="options"
        :loading="loading_tracking_delay"
        :server-items-length="this.total_items"
        :footer-props="{ itemsPerPageOptions: [10, 50, -1] }"
      >
        <template v-slot:[`item.id`]="{ index }">
          {{ (options.page - 1) * options.itemsPerPage + index + 1 }}
        </template>
        <template v-slot:[`item.tracking_date`]="{ item }">
          {{ item.tracking_date | date }}
        </template>
        <template v-slot:[`item.updated_at`]="{ item }">
          {{ item.updated_at | date }}
        </template>
        <template v-slot:top> </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-icon
            small
            class="mr-2"
            color="info"
            v-if="
              !trashed_delay &&
              permissionSimpleSelected.includes('update-delay-tracking')
            "
            @click="editItem(item)"
            :disabled="!item.is_last_loan_tracking"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            color="error"
            v-if="
              !trashed_delay &&
              permissionSimpleSelected.includes('delete-delay-tracking')
            "
            @click="deleteItem(item)"
            :disabled="!item.is_last_loan_tracking"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
      <v-dialog v-model="dialog" max-width="800px">
        <ValidationObserver ref="observerDelayTracking">
          <v-form>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }} </span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Tipo de seguimiento"
                        rules="required"
                      >
                        <v-select
                          :error-messages="errors"
                          dense
                          :loading="loading_tracking_types"
                          :items="tracking_types"
                          item-text="name"
                          item-value="id"
                          label="Tipo seguimiento"
                          v-model="editedItem.loan_tracking_type_id"
                        >
                        </v-select>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Fecha de acción"
                        rules="required"
                      >
                        <v-text-field
                          :error-messages="errors"
                          v-model="editedItem.tracking_date"
                          label="Fecha de acción"
                          hint="Día/Mes/Año"
                          class="purple-input"
                          type="date"
                          clearable
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12">
                      <ValidationProvider
                        v-slot="{ errors }"
                        name="Comentario"
                        rules="required"
                      >
                        <v-textarea
                          :error-messages="errors"
                          v-model="editedItem.description"
                          label="Comentario"
                          rows="4"
                        ></v-textarea>
                      </ValidationProvider>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="secondary" text @click="close()">
                  Cancelar
                </v-btn>
                <v-btn color="success" text @click="validateDelayTracking()">
                  Guardar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-form>
        </ValidationObserver>
      </v-dialog>
      <v-dialog v-model="dialogDelete" max-width="500px">
        <v-card>
          <v-card-title class="text-h5"
            >Esta seguro de eliminar el registro?</v-card-title
          >
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="secondary" text @click="closeDelete()"
              >Cancelar</v-btn
            >
            <v-btn color="success" text @click="deleteItemConfirm()"
              >Aceptar</v-btn
            >
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </template>
    <template v-else>
      <h3>EL PRÉSTAMO NO FUE DESEMBOLSADO AÚN.</h3>
    </template>
  </v-container>
</template>
<script>
import common from "@/plugins/common";
export default {
  name: "Delay-tracking",
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
  },
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "Nro",
        value: "id",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "3%",
        filterable: false,
      },
      {
        text: "Fecha de acción",
        value: "tracking_date",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
        filterable: false,
      },
      {
        text: "Usuario",
        value: "user.username",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
      },
      {
        text: "Tipo de seguimiento",
        value: "loan_tracking_type.name",
        class: ["normal", "white--text"],
        align: "left",
        sortable: true,
        width: "20%",
      },
      {
        text: "Comentario",
        value: "description",
        class: ["normal", "white--text"],
        align: "justify",
        sortable: true,
        width: "60%",
      },
      {
        text: "Fecha de registro",
        value: "updated_at",
        class: ["normal", "white--text"],
        align: "center",
        sortable: true,
        width: "5%",
      },
      {
        text: "Acciones",
        value: "actions",
        class: ["normal", "white--text"],
        align: "center",
        sortable: false,
        width: "10%",
        filterable: false,
      },
    ],
    tracking_delays: [],
    tracking_types: [],
    editedIndex: -1,
    editedItem: {
      loan_tracking_type_id: null,
      tracking_date: null,
      description: null,
    },
    defaultItem: {
      loan_tracking_type_id: null,
      tracking_date: null,
      description: null,
    },
    loading_tracking_delay: false,
    loading_tracking_types: false,
    dates: {
      trackingDate: {
        formatted: null,
        picker: false,
      },
    },
    options: {
      page: 1,
      itemsPerPage: 10,
    },
    trashed_delay: false,
    total_items: 0,
    val_tracking: false,
  }),

  computed: {
    itemsWithIndex() {
      return this.tracking_delays.map((items, index) => ({
        ...items,
        index: index + 1,
      }));
    },
    itemsWithIndex() {
      return this.tracking_delays.map((items, index) => ({
        ...items,
        index: index + 1,
      }));
    },
    itemsWithIndex() {
      return this.tracking_delays.map((items, index) => ({
        ...items,
        index: index + 1,
      }));
    },
    itemsWithIndex() {
      return this.tracking_delays.map((items, index) => ({
        ...items,
        index: index + 1,
      }));
    },
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Registro" : "Editar registro";
    },
    //Metodo para obtener Permisos por rol
    permissionSimpleSelected() {
      return this.$store.getters.permissionSimpleSelected;
    },
  },

  watch: {
    "editedItem.tracking_date": function (date) {
      this.formatDate("trackingDate", date);
    },
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    options: function (newVal, oldVal) {
      if (
        newVal.page != oldVal.page ||
        newVal.itemsPerPage != oldVal.itemsPerPage
      ) {
        this.getTrackingDelay();
      }
    },
    trashed_delay: function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.options.page = 1;
        this.getTrackingDelay();
      }
    },
  },

  created() {
    this.removeAccents = common.removeAccents;
    this.getTrackingDelay();
    this.getTrackingTypes();
  },

  methods: {
    formatDate(key, date) {
      if (date) {
        this.dates[key].formatted = this.$moment(date).format("L");
      } else {
        this.dates[key].formatted = null;
      }
    },
    async getTrackingDelay() {
      try {
        this.loading_tracking_delay = true;
        let res = await axios.get(`loan_tracking_delay`, {
          params: {
            loan_id: this.$route.params.id,
            page: this.options.page,
            per_page: this.options.itemsPerPage,
          },
        });
        if (!this.trashed_delay) {
          this.tracking_delays = res.data.data.loan_tracking_delays.data;
          this.options.page = res.data.data.loan_tracking_delays.current_page;
          this.options.itemsPerPage = parseInt(
            res.data.data.loan_tracking_delays.per_page
          );
          this.total_items = res.data.data.loan_tracking_delays.total;
        } else {
          this.tracking_delays =
            res.data.data.loan_tracking_delays_removed.data;
          this.options.page =
            res.data.data.loan_tracking_delays_removed.current_page;
          this.options.itemsPerPage = parseInt(
            res.data.data.loan_tracking_delays_removed.per_page
          );
          this.total_items = res.data.data.loan_tracking_delays_removed.total;
        }
        this.loading_tracking_delay = false;
      } catch (e) {
        console.log(e);
      } finally {
        this.loading_tracking_delay = false;
      }
    },
    async getTrackingTypes() {
      try {
        this.tracking_types_loading = true;
        let res = await axios.get("get_loan_trackings_types");
        this.tracking_types = res.data.data;
        console.log(this.tracking_types);
        this.tracking_types_loading = false;
      } catch (e) {
        console.log(e);
        this.tracking_types_loading = false;
      }
    },

    editItem(item) {
      console.log(item);
      item.tracking_date = this.$moment(item.tracking_date).format(
        "YYYY-MM-DD"
      );
      console.log(item.tracking_date);
      this.editedIndex = this.tracking_delays.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.tracking_delays.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    async deleteItemConfirm() {
      try {
        let res = await axios.delete(
          `loan_tracking_delay/${this.editedItem.id}`
        );
        //this.tracking_delays.splice(this.editedIndex, 1);
        this.getTrackingDelay();
        this.closeDelete();
        this.toastr.success("Se eliminó correctamente el registro.");
      } catch (e) {
        console.log(e);
      }
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    async saveTracking() {
      try {
        if (this.editedIndex == -1) {
          let res = await axios.post("loan_tracking_delay", {
            loan_tracking_type_id: this.editedItem.loan_tracking_type_id,
            loan_id: this.$route.params.id,
            tracking_date: this.editedItem.tracking_date,
            description: this.editedItem.description,
          });
          this.getTrackingDelay();
          this.toastr.success("Se realizó el registró correctamente.");
        } else {
          let res = await axios.patch(
            `loan_tracking_delay/${this.editedItem.id}`,
            {
              loan_tracking_type_id: this.editedItem.loan_tracking_type_id,
              loan_id: this.$route.params.id,
              tracking_date: this.editedItem.tracking_date,
              description: this.editedItem.description,
            }
          );
          this.getTrackingDelay();
          this.toastr.success("Se actualizó el registro correctamente.");
        }
        this.dialog = false;
      } catch (e) {
        console.log(e);
        this.dialog = false;
      }
    },
    async validateDelayTracking() {
      try {
        this.val_tracking = await this.$refs.observerDelayTracking.validate();
        if (this.val_tracking == true) {
          this.saveTracking();
        }
      } catch (e) {
        this.$refs.observerDelayTracking.setErrors(e);
      }
    },

    async printDelayTracking(item) {
      try {
        let res = await axios.get(`loan/${item}/print/delay_tracking`);
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
  },
};
</script>