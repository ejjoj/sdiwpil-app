<template>
  <v-row>
    <v-col md="4">
      <h1 class="text-h4 appointment-white mb-2">
        Witaj w panelu wizyt
      </h1>

      <p class="appointment-white">
        W tej sekcji możesz sprawdzić umówione w przeszłości wizyty, które znajdują się na poniższej liście, lub umówić się na nową wizytę lekarską.
      </p>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'PatientAppointmentScreen',
};
</script>

<style scoped>
.appointment-white {
  color: #fff;
}
</style>
