<template>
  <v-container fluid>
    <ValidationObserver>
      <v-form>
        <v-card flat>
          <v-card-title class="pa-0 pb-3">
            <v-toolbar dense color="tertiary" class="font-weight-regular">
              <v-toolbar-title>GENERACIÓN AUTOMÁTICA DE COBROS</v-toolbar-title>
            </v-toolbar>
          </v-card-title>
          <template>
            <v-container fluid class="px-2 pt-0">
              <v-row justify="center" class="py-0">
                <v-col cols="12" class="py-0">
                  <v-tabs dark active-class="secondary" v-model="tab">
                    <v-tab v-for="item in actions" :key="item.nameTab">{{item.nameTab}}</v-tab>
                  </v-tabs>
                  <v-tabs-items v-model="tab">
                    <v-tab-item v-for="item in actions" :key="item.nameTab">
                      <v-card flat tile>
                        <v-card-text class="pa-2">
                          <v-row align="center" no-gutters>
                            <v-col cols="4" class="pa-2">
                              <v-toolbar-title>
                                <b>Información para descuento</b>
                              </v-toolbar-title>
                              <v-progress-linear></v-progress-linear>
                              <br />
                              <v-layout row wrap>
                                <v-col cols="12" md="12" class="py-0">
                                  <v-text-field
                                    dense
                                    v-model="import_export.cutoff_date"
                                    label="Fecha de corte"
                                    hint="Día/Mes/Año"
                                    type="date"
                                    outlined
                                  ></v-text-field>
                                </v-col>
                                <v-col
                                  cols="12"
                                  md="12"
                                  class="py-0"
                                  v-if="item.value == 'import'"
                                >
                                  <ValidationProvider
                                    v-slot="{ errors }"
                                    name="Estado del afiliado"
                                    rules=""
                                  >
                                    <v-select
                                      :error-messages="errors"
                                      dense
                                      :items="state_affiliate"
                                      item-text="name"
                                      item-value="value"
                                      label="Estado del afiliado"
                                      outlined
                                      v-model="import_export.state_affiliate"
                                    ></v-select>
                                  </ValidationProvider>
                                </v-col>

                                <v-col
                                  cols="12"
                                  md="12"
                                  class="py-0"
                                  v-if="item.value == 'import'"
                                >
                                  <v-file-input
                                    counter
                                    show-size
                                    truncate-length="30"
                                    outlined
                                    small-chips
                                    dense
                                    label="Importar información"
                                    v-model="import_export.file"
                                  ></v-file-input>
                                </v-col>
                                <br />
                                <v-col
                                  cols="12"
                                  md="4"
                                  class="py-0"
                                  v-if="item.value == 'export'"
                                >
                                  <v-btn
                                    color="primary"
                                    :loading="loading_rpb"
                                    @click.stop="registerPaymentsBatch()"
                                    >Generar Información</v-btn
                                  >
                                  <br /><br /><br />

                                </v-col>
                                <v-col
                                  cols="12"
                                  md="4"
                                  class="py-0"
                                  v-if="item.value == 'import'"
                                >
                                  <v-btn
                                    color="primary"
                                    :loading="loading_ipb"
                                    @click.stop="importationPaymentsBatch()"
                                    >Importar Información</v-btn
                                  >
                                  <br /><br />
                                </v-col>
                              </v-layout>
                            </v-col>
                            <v-col cols="6" class="pa-2"></v-col>
                          </v-row>
                        </v-card-text>
                      </v-card>
                    </v-tab-item>
                  </v-tabs-items>
                </v-col>
              </v-row>
            </v-container>
          </template>
        </v-card>
      </v-form>
    </ValidationObserver>
  </v-container>
</template>


<script>
export default {
  name: "payment-ImportExport",
  data: () => ({
    tab: null,
    import_export: {
      file: null,
      state_affiliate: null,
      cutoff_date: null,
    },
    actions: [
      { nameTab: "Exportación", value: "export" },
      { nameTab: "Importación", value: "import" },
    ],
    state_affiliate: [
      { name: "Activo - Comando", value: 1 },
      { name: "Pasivo - Senasir", value: 0 },
    ],
    paymentsBatch: [],
    datos: [],
    import_payments: {
      automatic: 0,
      no_automatic: 0,
    },
    visible: false,
    loading_rpb: false,
    loading_ipb: false,

  }),
  methods: {
    clearInputs() {
      this.import_export.file = null
      this.import_export.state_affiliate = null
      this.import_export.cutoff_date = null
    },

    /*async registerPaymentsBatch() {
      try {
        this.loading_rpb = true;
        let res = await axios.post(`command_senasir_save_payment`, {
          estimated_date: this.import_export.cutoff_date,
        });
        this.paymentsBatch = res.data;
        this.toastr.success("Se realizo el registro de: " + this.paymentsBatch.loans_quantity + " pago del mes de " + this.import_export.cutoff_date);
        console.log(this.paymentsBatch);
      } catch (e) {
        console.log(e);
      }
      this.loading_rpb = false;
    },*/

    async registerPaymentsBatch() {
      const formData = new FormData();
      formData.append("estimated_date", this.import_export.cutoff_date);
      this.loading_rpb = true;
      await axios({
        url: "command_senasir_save_payment",
        method: "POST",
        responseType: "blob", // important
        headers: { Accept: "application/vnd.ms-excel" },
        data: formData,
      })
        .then((response) => {
          console.log(response.data);
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "ReporteDecuento.xls");
          document.body.appendChild(link);
          link.click();
          this.clearInputs();
        })
        .catch((e) => {
          console.log(e);
        });
      this.loading_rpb = false;
    },

    async importationPaymentsBatch() {
      const formData = new FormData();
      formData.append("file", this.import_export.file);
      formData.append("state", this.import_export.state_affiliate);
      formData.append("estimated_date", this.import_export.cutoff_date);
      this.loading_ipb = true
      await axios({
        url: "/loan_payment/importation_command_senasir",
        method: "POST",
        responseType: "blob", // important
        headers: { Accept: "application/vnd.ms-excel" },
        data: formData,
      })
        .then((response) => {
          console.log(response.data);
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "ReporteDecuento.xls");
          document.body.appendChild(link);
          link.click();
          this.clearInputs();
        })
        .catch((e) => {
          console.log(e);
        });
      this.loading_ipb = false;
    },
  },
};
</script>
