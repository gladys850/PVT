<template>
  <v-card flat >
    <v-card-title>
      <v-toolbar dense color="tertiary">
        <v-toolbar-title>Préstamos SISMU</v-toolbar-title>
      </v-toolbar>
    </v-card-title>
    <v-card-text v-if="permissionSimpleSelected.includes('show-history-loan')">
      <v-container class="py-0 px-0">
        <ValidationObserver ref="observer">
            <v-row align="start">
              <v-col cols="12" md="4">
                <v-card>
                  <v-container class="py-0 pb-2">
                    <v-row>
                      <v-col cols="12" md="4"></v-col>
                      <v-col cols="12" md="6"> Codigo de Prestamo </v-col>
                      <v-col cols="12" md="2"></v-col>
                      <v-col cols="12" md="1"></v-col>
                      <v-col cols="12" md="8">
                        <ValidationProvider v-slot="{ errors }"
                        vid="sismu_code"
                        name="Codigo SISMU"
                        rules="required|min:3|max:20">
                        <v-text-field
                        :error-messages="errors"
                          dense
                          label="Codigo de prestamo"
                          v-model="sismu_code"
                          class="py-0"
                          single-line
                          hide-details
                          clearable
                          :loading="loading"
                          v-on:keyup.enter="validar()"
                        ></v-text-field>
                        </ValidationProvider>
                      </v-col>
                      <v-col cols="12" md="2">
                        <v-tooltip top>
                          <template v-slot:activator="{ on }">
                            <v-btn
                              fab
                              dark
                              x-small
                              v-on="on"
                              color="info"
                              :loading="loading"
                              @click.stop="validar()"
                            >
                              <v-icon>mdi-magnify</v-icon>
                            </v-btn>
                          </template>
                        </v-tooltip>
                      </v-col>
                    </v-row>
                    <v-row class="ma-0 pb-0 text-uppercase" v-if=ver_inexistencia>
                    <v-col class="text-center" cols="12" md="12">
                      <h3 class="error--text aling-text-center">
                        NO EXISTE UNA COINCIDENCIA EXACTA <br>
                      </h3>
                    </v-col>
                  </v-row>
                  </v-container>
                </v-card>
              </v-col>
            </v-row>
            <template v-if="ver">
              <h2 class="pa-1 text-center">PRÉSTAMOS</h2>
              <br>
              <v-row>
                <v-col cols="12" md="12" class="py-0">
                  <v-card>
                    <v-data-table
                      class="text-uppercase"
                      dense
                      :headers="headers_sismu"
                      :items="loans"
                      :items-per-page="10"
                      :footer-props="{ itemsPerPageOptions: [10, 15, 30] }"
                    >
                    <template v-slot:item.actions="{ item }">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-btn
                            @click="showUpdate(item)"
                            color="success"
                            x-small
                            absolute
                            right
                            style="margin-right: 50px; margin-top: -15px;"
                            v-on="on"
                          >
                            <v-icon> mdi-refresh </v-icon>
                          </v-btn>
                        </template>
                        <span class="caption">Actualizar saldo</span>
                      </v-tooltip>
                      <v-dialog v-model="dialogUpdate" max-width="700px">
                    <v-card>
                      <v-card-title class="text-h6"
                        >Esta seguro de Actualizar el saldo de prestamo {{sismu_code}}?</v-card-title>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="secondary" text @click="closedUpdate()">Cancelar</v-btn>
                        <v-btn color="success" text @click="sismuAction(item.IdPrestamo)">Aceptar</v-btn>
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                    </template>
                    </v-data-table>
                  </v-card>
                </v-col>
              </v-row>
            </template>
        </ValidationObserver>
      </v-container>
    </v-card-text>
  </v-card>
</template>
<script>

export default {
  name: "index",

  data: () => ({
    loans: {},
    dialogUpdate: false,
    sismu_code: null,
    loading: false,
    ver: false,
    ver_inexistencia: false,
    headers_sismu: [
      {
        text: "Nombre completo",
        class: ["normal", "white--text"],
        align: "left",
        value: "full_name",
      },
      {
        text: "CI",
        class: ["normal", "white--text"],
        align: "left",
        value: "identity_card",
      },
      {
        text: "Codigo de Préstamo",
        class: ["normal", "white--text"],
        align: "left",
        value: "code",
      },
      {
        text: "Fecha de desembolso",
        class: ["normal", "white--text"],
        align: "left",
        value: "disbursement_date",
      },
      {
        text: "Plazo",
        class: ["normal", "white--text"],
        align: "left",
        value: "loan_term",
      },
      {
        text: "Cuota mensual",
        class: ["normal", "white--text"],
        align: "left",
        value: "quota",
      },
      {
        text: "Saldo Actual",
        class: ["normal", "white--text"],
        align: "left",
        value: "balance",
      },
      {
        text: "Estado",
        class: ["normal", "white--text"],
        align: "left",
        value: "state",
      },
      {
        text: "Monto Desembolsado",
        class: ["normal", "white--text"],
        align: "left",
        value: "amount",
      },
      {
        text: "Acción",
        class: ["normal", "white--text"],
        align: "left",
        value: "actions",
      },
    ],
  }),
  computed:{
    permissionSimpleSelected () {
      return this.$store.getters.permissionSimpleSelected
    }
  },
  watch:{
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {

    async validar() {
      if (await this.$refs.observer.validate()) {
        this.getLoanSismu()
      }
  },
    //obtener los afiliados u observables
    async getLoanSismu() {
      try {
        this.loading = true;
        let res = await axios.post(`loan_sismu`, {
          code: this.sismu_code,
        });
        if (res.data.length != 0) {
          this.ver = true;
          this.ver_inexistencia = false;
          this.loans = res.data.map(item => ({
            IdPrestamo: item.IdPrestamo,
            full_name: item.full_name,
            identity_card: item.PadCedulaIdentidad,
            code: item.PresNumero,
            disbursement_date: item.PresFechaDesembolso,
            loan_term: item.PresMeses,
            quota: item.PresCuotaMensual,
            balance: item.PresSaldoAct,
            state: item.PresEstPtmo,
            amount: item.PresMntDesembolso
          }));
        } else {
          this.ver = false;
          this.ver_inexistencia = true;
          this.loans = [];
        }
      } catch (e) {
        this.$refs.observer.setErrors(e)
      } finally {
        this.loading = false;
      }
    },
    async sismuAction(IdPrestamo) {
      try{
        let res = await axios.post(`update_balance_sismu`, {
            IdPrestamo: IdPrestamo,
            role_id: this.$store.getters.rolePermissionSelected.id,
            balance: this.loans[0].balance,
          });
        if(res.data.status)
          this.toastr.success('Registro actualizado correctamente')
        this.dialogUpdate = false;
        this.validar();
      }catch (e) {
        console.log(e)
      }
    },
    showUpdate(item) {
      this.dialogUpdate = true;
    },
    closedUpdate(IdPrestamo) {
      this.dialogUpdate = false;
    }
  },
};
</script>
