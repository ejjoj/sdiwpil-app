<template>
  <div>
    <v-container fluid>
      <app-background color-schema="doctor" />
    </v-container>

    <v-container
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <route-screen
        header="Lista umówionych wizyt"
        text="Poniższa lista przedstawia umówione w systemie wizyty lekarskie przez pacjentów."
      />

      <doctor-appointments-list />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import containerHelper from '../../../../mixins/containerHelper';
import DoctorAppointmentsList from './DoctorAppointmentsList';

export default {
  name: 'DesktopContainer',
  components: { DoctorAppointmentsList, AppBackground, RouteScreen },
  mixins: [containerHelper],
};
</script>

<style scoped lang="scss">
::v-deep {
  .background {
    z-index: 0;
  }
}

.container {
  position: relative;
}
</style>
