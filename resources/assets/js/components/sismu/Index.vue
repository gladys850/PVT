<template>
  <v-card flat>
    <v-card-title>
      <v-toolbar dense>
        <v-toolbar-title>Préstamos SISMU </v-toolbar-title>
        <v-btn
          fab
          dark
          x-small
          v-if="$store.getters.rolePermissionSelected!=null"
          color="#000"
          outlined
          class="mx-3"
          @click="$router.push('/changeRol')">
          <v-icon>mdi-keyboard-return</v-icon>
        </v-btn>
      </v-toolbar>
    </v-card-title>

    <v-card-text>
      <v-container>
        <ValidationObserver ref="observer">
          <v-row>
            <v-col cols="12" md="4">
              <v-card>
                <v-container>
                  <v-row>                   
                    <v-col cols="12" md="10">
                      <ValidationProvider v-slot="{ errors }" vid="sismu_code" name="Código SISMU" rules="required|min:3|max:20">
                        <v-text-field
                          v-model="sismu_code"
                          label="Código de préstamo"
                          dense
                          clearable
                          :error-messages="errors"
                          :loading="loading"
                          @keyup.enter="validar"
                        ></v-text-field>
                      </ValidationProvider>
                    </v-col>
                    <v-col cols="12" md="2">
                      <v-btn 
                        fab 
                        dark 
                        x-small 
                        color="normal" 
                        :loading="loading" 
                        @click="validar">
                        <v-icon>mdi-magnify</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>

                  <v-row v-if="ver_inexistencia">
                    <v-col class="text-center">
                      <h3 class="error--text">NO EXISTE UNA COINCIDENCIA EXACTA</h3>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-col>
          </v-row>

          <template v-if="ver">
            <h2 class="text-center my-4">PRÉSTAMOS</h2>
            <v-row>
              <v-col cols="12">
                <v-card>
                  <v-data-table
                    dense
                    :headers="headers_sismu"
                    :items="loans"
                    :items-per-page="10"
                    :footer-props="{ itemsPerPageOptions: [10, 15, 30] }"
                  >
                  <template v-slot:[`item.disbursement_date`]="{ item }">
                    {{ item.disbursement_date | date }}
                  </template>
                  <template v-slot:[`item.quota`]="{ item }">
                    {{ item.quota | moneyString }}
                  </template>
                  <template v-slot:[`item.balance`]="{ item }">
                    {{ item.balance | moneyString }}
                  </template>
                  <template v-slot:[`item.interest_pending`]="{ item }">
                    {{ item.interest_pending | moneyString }}
                  </template>
                  <template v-slot:[`item.amount`]="{ item }">
                    {{ item.amount | moneyString }}
                  </template>
                    <template v-slot:item.actions="{ item }">
                      <!--actualizar saldo-->
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn 
                            v-on="on"
                            color="success" 
                            x-small 
                            icon 
                            @click="dialog_balance = true">
                            <v-icon>mdi-refresh</v-icon>
                          </v-btn>
                        </template>
                        <div>
                          <span>Editar balance</span>
                        </div>
                      </v-tooltip>

                      <v-dialog v-model="dialog_balance" max-width="700px">
                        <v-card>
                          <v-card-title class="text-h6">
                            ¿Está seguro de actualizar el saldo del préstamo {{ sismu_code }}?
                          </v-card-title>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialog_balance = false">Cancelar</v-btn>
                            <v-btn color="success" text @click="updateSismuBalance(item.IdPrestamo)">Aceptar</v-btn>
                            <v-spacer></v-spacer>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>

                      <!--Actualizar interes penal-->
                      <v-tooltip top>
                        <template v-slot:activator="{ on }">
                          <v-btn 
                            v-on="on"
                            color="warning" 
                            x-small 
                            icon 
                            @click="dialog_input = true">
                            <v-icon>mdi-table-edit</v-icon>
                          </v-btn>
                        </template>
                        <div>
                          <span>Editar Interes penal</span>
                        </div>
                      </v-tooltip>
                      <v-dialog v-model="dialog_input" max-width="700px">
                        <v-card>
                          <v-toolbar dense flat>
                            <v-card-title>Editar</v-card-title>                          
                          </v-toolbar>
                          <v-divider></v-divider>
                          <v-card-text class="text-h6 pt-4">
                            <v-text-field
                                dense
                                v-model="mount_interest"
                                label="Registrar interes pendiente"
                                clearable
                            ></v-text-field>
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialog_input = false">Cancelar</v-btn>
                            <v-btn color="success" text @click="dialog_interest =true; dialog_input = false">Aceptar</v-btn>
                            <v-spacer></v-spacer>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-dialog v-model="dialog_interest" max-width="700px">
                        <v-card>
                          <v-card-title class="text-h6">
                            ¿Está seguro de actualizar el interes pendiente del préstamo {{ sismu_code }}?
                          </v-card-title>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialog_interest = false">Cancelar</v-btn>
                            <v-btn color="success" text @click="updateSismuInterest(item.IdPrestamo)">Aceptar</v-btn>
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
    loans: [],
    dialog_balance: false,
    dialog_input: false,
    dialog_interest: false,
    sismu_code: "",
    loading: false,
    ver: false,
    ver_inexistencia: false,
    mount_interest: 0,
    headers_sismu: [
      { text: "Nombre completo", align: "left", value: "full_name" },
      { text: "CI", align: "left", value: "identity_card" },
      { text: "Codigo de Préstamo", align: "left", value: "code" },
      { text: "Fecha de desembolso", align: "left", value: "disbursement_date" },
      { text: "Plazo", align: "left", value: "loan_term" },
      { text: "Cuota mensual", align: "left", value: "quota" },
      { text: "Saldo Actual", align: "left", value: "balance" },
      { text: "Interes Pendiente", align: "left", value: "interest_pending" },
      { text: "Estado", align: "left", value: "state" },
      { text: "Monto Desembolsado", align: "left", value: "amount" },
      { text: "Acción", align: "left", value: "actions" },
    ],
  }),

  computed: {
    permissionSimpleSelected() {
      return this.$store.getters.permissionSimpleSelected;
    }
  },

  methods: {
    async validar() {
      if (await this.$refs.observer.validate()) {
        this.getLoanSismu()
      }
    },

    async getLoanSismu() {
      this.loading = true;
      try {
        const res = await axios.post("loan_sismu", { 
          code: this.sismu_code 
        })
        this.loans = res.data.length
          ? res.data.map(item => ({
              IdPrestamo: item.IdPrestamo,
              full_name: item.full_name,
              identity_card: item.PadCedulaIdentidad,
              code: item.PresNumero,
              disbursement_date: item.PresFechaDesembolso,
              loan_term: item.PresMeses,
              quota: item.PresCuotaMensual,
              balance: item.PresSaldoAct,
              state: item.PresEstPtmo,
              amount: item.PresMntDesembolso,
              interest_pending: item.PresIntPendientes
            }))
          : [];

        this.ver = !!res.data.length;
        this.ver_inexistencia = !this.ver;
      } catch (e) {
        this.$refs.observer.setErrors(e);
      } finally {
        this.loading = false;
      }
    },

    async updateSismuBalance(IdPrestamo) {
      try {
        const res = await axios.post("update_balance_sismu", {
          IdPrestamo: IdPrestamo,
          role_id: this.$store.getters.rolePermissionSelected.id,
          balance: this.loans.find(loan => loan.IdPrestamo === IdPrestamo)?.balance || 0
        });

        if (res.data.status) {
          this.toastr.success("Registro actualizado correctamente");
        }

        this.dialog_balance = false;
        this.validar();
      } catch (error) {
        console.error(error);
      }
    },

    async updateSismuInterest(IdPrestamo){
      try {
        const res = await axios.post("udpate_pending_interest", {
        IdPrestamo: IdPrestamo,
        current_role_id: this.$store.getters.rolePermissionSelected.id,
        new_interest_pending: this.mount_interest,
        role_id: this.$store.getters.rolePermissionSelected.id,
      });

        if(res.data.status) {
          this.toastr.success("Registro actualizado correctamente de interes pendiente");
        }

        this.dialog_interest = false
        this.validar()
      } catch (e) {
        console.error(e)
      }

    },
  }
};
</script>
