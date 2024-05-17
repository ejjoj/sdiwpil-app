<template>
  <v-data-table
    :headers="headers"
    :items="appointments"
    no-data-text="Dla twojego konta nie zostały jeszcze utworzone żadne wizyty"
    :options.sync="options"
    :footer-props="{
      'items-per-page-text': 'Ilość wierszy na stronie',
      'items-per-page-options': rowsPerPageItems,
      'page-text': '{0}-{1} z {2}',
    }"
  >
    <template #top>
      <v-toolbar flat>
        <v-toolbar-title>Umówione wizyty</v-toolbar-title>
      </v-toolbar>
    </template>
  </v-data-table>
</template>

<script>
import { mapState } from 'vuex';
import { DOCTOR_APPOINTMENTS } from '../../../../store/module-namespaces';
import { APPOINTMENTS } from '../../../../store/module-state-properties';

export default {
  name: 'DoctorAppointmentsList',
  data: () => ({
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
    headers: [
      {
        text: 'Pacjent',
        sortable: false,
        value: 'patient',
      },
      {
        text: 'Powód wizyty',
        sortable: false,
        value: 'patientReason',
      },
      {
        text: 'Data wizyty',
        sortable: false,
        value: 'scheduledAt',
      },
    ],
  }),
  computed: {
    ...mapState(DOCTOR_APPOINTMENTS, {
      appointments: APPOINTMENTS,
    }),
  },
};
</script>

<style scoped>

</style>
