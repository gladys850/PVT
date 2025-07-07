<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
  >
    <v-card>
      <v-toolbar dense flat>
        <v-card-title v-show="address.edit">Añadir Dirección</v-card-title>
        <v-card-title v-show="!address.edit">Dirección</v-card-title>
      </v-toolbar>

      <v-divider></v-divider>

      <v-card-text>
        <v-container fluid>
          <v-row justify="center">
            <v-col cols="12">
              <v-container class="py-0">
                <ValidationObserver ref="observer">
                  <v-form>
                    <v-row>
                      <v-col cols="12" md="3" v-show="address.edit" class="pb-0 mb-0">
                        <v-select
                          dense
                          :items="countryCities"
                          item-text="name"
                          item-value="id"
                          label="Ciudad"
                          v-model="address.city_address_id"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" md="9" v-show="address.edit" class="pb-0 mb-0">
                        <ValidationProvider v-slot="{ errors }" vid="description" name="Dirección" rules="required">
                          <v-text-field
                            :error-messages="errors"
                            dense
                            v-model="address.description"
                            label="Dirección"
                            class="purple-input"
                          ></v-text-field>
                        </ValidationProvider>
                      </v-col>

                      <v-col cols="12" md="12" class="pb-0 mb-0">
                        <LMap
                          v-if="dialog"
                          :address.sync="address"
                        />
                      </v-col>
                    </v-row>
                  </v-form>
                </ValidationObserver>
              </v-container>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions v-show="address.edit" class="pt-0 mt-0">
        <v-spacer></v-spacer>
        <v-btn color="error" text @click.stop="close()">Cerrar</v-btn>
        <v-btn color="success" text @click.stop="adicionar()">Guardar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import LMap from '@/components/affiliate/LMap'

export default {
  name: "affiliate-addresses",
  props: {
    bus: {
      type: Object,
      required: true
    },
    cities: {
      type: Array,
      required: true
    }
  },
  components: {
    LMap
  },
  data: () => ({
    dialog: false,
    address: {
      city_address_id: '',
      description: null,
      id: null,      
      latitude: null,
      longitude: null,
    }
  }),
  mounted() {
    this.bus.$on('openDialog', (address) => {
      this.address = { ...address, edit: true } // marca si está en edición
      this.dialog = true
    })
  },
  computed: {
    countryCities() {
      return this.cities.filter(o => o.name.toUpperCase() != 'NATURALIZADO' &&  o.name.toUpperCase() != 'NINGUNO')
    }
  },
  methods: {
    async adicionar() {
      if (await this.$refs.observer.validate()) {
        this.saveAddress()
        this.bus.$emit('saveAddress', this.address)
        this.close()
      }
    },
    close() {
      this.dialog = false
      this.address = {}
    },

    async saveAddress() {
      try {
        if (this.address.id) {
          let res = await axios.patch(`address/${this.address.id}`, this.address)
          this.toastr.success('Domicilio Modificado')
          this.bus.$emit('saveAddress', res.data)
        } else {
          let res = await axios.post(`address`, this.address)
          this.toastr.success('Domicilio Adicionado')
          this.bus.$emit('saveAddress', res.data)
        }
      } catch (e) {
        this.$refs.observer.setErrors(e)
      }
    }
  }
}
</script>