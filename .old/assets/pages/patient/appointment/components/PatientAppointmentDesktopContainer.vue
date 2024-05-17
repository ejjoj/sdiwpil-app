<template>
  <div>
    <v-container fluid>
      <app-background />
    </v-container>

    <v-container
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <patient-appointment-screen />

      <patient-appointment-list />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import PatientAppointmentScreen from './PatientAppointmentScreen';
import PatientAppointmentList from './PatientAppointmentList';

export default {
  name: 'PatientAppointmentDesktopContainer',
  components: { PatientAppointmentList, PatientAppointmentScreen, AppBackground },
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
}
</style>
