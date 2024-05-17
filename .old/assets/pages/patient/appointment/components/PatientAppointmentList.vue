<template>
  <v-data-table
    :headers="headers"
    :items="appointments"
    no-data-text="Dla twojego konta nie została zarejestrowana żadna wizyta"
    :options.sync="options"
    :loading="loading"
    :footer-props="{
      'items-per-page-text': 'Ilość wierszy na stronie',
      'items-per-page-options': rowsPerPageItems,
      'page-text': '{0}-{1} z {2}',
    }"
  >
    <template #top>
      <v-toolbar flat>
        <v-toolbar-title>Historia wizyt</v-toolbar-title>
        <v-spacer />
        <v-dialog
          v-model="dialog"
          persistent
          max-width="500px"
          @keydown.esc="dialog = false"
        >
          <template #activator="{ on, attrs }">
            <v-btn
              color="primary"
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              Umów wizytę
            </v-btn>
          </template>
          <v-card
            :loading="loading"
          >
            <v-card-title class="mb-2">
              Wypełnij formularz wizyty
            </v-card-title>
            <v-card-text>
              <patient-appointment-stepper
                @appointmentsChange="setAppointments"
                @closeModal="dialog = false"
              />
            </v-card-text>
            <v-card-actions>
              <v-btn
                color="warning"
                class="mb-2"
                @click="dialog = false"
              >
                Zamknij
              </v-btn>
              <v-spacer />
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
  </v-data-table>
</template>

<script>
import { get } from 'lodash';
import PatientAppointmentStepper from './PatientAppointmentStepper';

export default {
  name: 'PatientAppointmentList',
  components: { PatientAppointmentStepper },
  data: () => ({
    headers: [
      {
        text: 'Lekarz',
        sortable: false,
        value: 'doctor',
      },
      {
        text: 'Specjalizacja lekarza',
        sortable: false,
        value: 'medicalSpecialty',
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
    dialog: false,
    errors: [],
    appointments: [],
    loading: false,
    options: {
      itemsPerPage: 25,
      page: 1,
    },
    rowsPerPageItems: [25, 50, 100, 250],
  }),
  mounted() {
    this.appointments = get(window, 'state.appointments', []);
  },
  methods: {
    setAppointments(appointments) {
      this.appointments = appointments;
    },
  },
};
</script>

<style scoped>

</style>
