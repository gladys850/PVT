<template>
    <v-container fluid class="mt-0 pt-0">
            <v-row>
                <v-col cols="12" class="pb-0 mb-0">
                    <p style="color: teal">
                        <b>DATOS DE GARANTIAS</b>
                    </p>
                </v-col>
            </v-row>
            <v-row >
                <v-col cols="12" sm="12" :md="col_size" class="mt-0 pt-0" >
                    <v-data-table
                        dense
                        :headers="headers"
                        :items="borrowerguarantors"
                        hide-default-footer
                        class="elevation-1"
                    >
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{ item.name }}</td>
                            <td>{{ item.code }}</td>
                            <td>{{ item.state }}</td>
                            <td>{{ item.type }}</td>
                            <td>
                                <v-simple-checkbox
                                    disabled
                                    color="red"
                                    value=item.evaluate
                                >
                                </v-simple-checkbox>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    props: {
        borrowerguarantors: {
        type: Object,
        required: true,
        }
    },
data: () => ({
    col_size: 10,
    type: "",
    ballot_adjust: [],
    average_ballot_adjust: null,
    headers: [
        {
            text: "Titular",
            align: "start",
            sortable: false,
            value: "name",
            class: "white--text",
        },
        {
            text: "Codigo",
            sortable: false,
            value: "code",
            class: "white--text",
        },
        {
            text: "Estado",
            sortable: false,
            value: "state",
            class: "white--text",
        },
        {
            text: "Tipo de tramite",
            sortable: false,
            value: "type",
            class: "white--text",
        },
        {
            text: "Garantia Evaluada",
            sortable: false,
            value: "evaluate",
            class: "white--text",
        }
    ],
})
}
</script>