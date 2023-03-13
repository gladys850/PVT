<template>
  <div>
    <v-row>
      <v-col cols="12">
        <v-tabs dark active-class="secondary">
           <v-tab>OBSERVACIONES DEL AFILIADO</v-tab>

          <v-tab-item>
            <v-card flat tile>
              <v-card-text>
                <v-col cols="12" class="mb-0">
                  <ObservationAffiliate :affiliate="affiliate" />
                </v-col>
              </v-card-text>
            </v-card>
          </v-tab-item>

          <v-tab>HISTORIAL DEL AFILIADO</v-tab>
          <v-tab-item>
            <v-card flat tile>
              <v-card-text>
                <v-col cols="12" class="mb-0">
                  <HistoryAffiliate :affiliate="affiliate" />
                </v-col>
              </v-card-text>
            </v-card>
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import HistoryAffiliate from "@/components/affiliate/HistoryAffiliate"
import ObservationAffiliate from "@/components/affiliate/ObservationAffiliate"

export default {
  name: "observer-affiliate",
  components: {
    HistoryAffiliate,
    ObservationAffiliate,
  },
  props: {
    affiliate: {
      type: Object,
      required: true,
    },
    observations: {
      type: Array,
      required: true
    },
  },
};
</script>
