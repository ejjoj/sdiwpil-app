<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background />

    <patient-appointment-screen />

    <patient-appointment-list />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import PatientAppointmentScreen from './PatientAppointmentScreen';
import PatientAppointmentList from './PatientAppointmentList';

export default {
  name: 'PatientAppointmentMobileContainer',
  components: { PatientAppointmentList, AppBackground, PatientAppointmentScreen },
  props: {
    navbarHeight: {
      type: Number,
      required: true,
    },
    footerHeight: {
      type: Number,
      required: true,
    },
  },
};
</script>

<style scoped>
.container {
  position: relative;
  z-index: 2;
  overflow-x: hidden;
}
</style>
