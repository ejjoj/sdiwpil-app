<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background />

    <route-screen
      header="Lista umówionych wizyt"
      text="Poniższa lista przedstawia umówione w systemie wizyty lekarskie przez pacjentów."
    />

    <doctor-appointments-list />
  </v-container>
</template>

<script>
import containerHelper from '../../../../mixins/containerHelper';
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DoctorAppointmentsList from './DoctorAppointmentsList';

export default {
  name: 'MobileContainer',
  components: { DoctorAppointmentsList, RouteScreen, AppBackground },
  mixins: [containerHelper],
};
</script>

<style scoped>
.container {
  position: relative;
  z-index: 2;
  overflow-x: hidden;
}
</style>
