<template>
  <v-form>
    <v-select
      v-model="scheduledAt"
      :items="appointmentDates"
      label="Wybierz godzinę wizyty"
    />
    <v-textarea
      v-model="patientReason"
      label="Wpisz powód wizyty"
    />
  </v-form>
</template>

<script>
export default {
  name: 'PatientAppointmentRestInfoForm',
  props: {
    appointmentDates: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    scheduledAt: '',
    patientReason: '',
  }),
  watch: {
    scheduledAt(newValue) {
      this.$emit('scheduledAtChange', newValue);
    },
    patientReason(newValue) {
      this.$emit('patientReasonChange', newValue);
    },
  },
};
</script>

<style scoped>

</style>
