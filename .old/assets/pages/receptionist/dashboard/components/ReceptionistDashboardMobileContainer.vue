<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="receptionist" />

    <route-screen
      header="Witaj w panelu recepcjonisty"
      text="Poniżej znajdują się odnośniki do poszczególnych funkcji systemu. Skorzystaj z nich by rozpocząć akcję."
    />

    <dashboard-functions :functions="functions" />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DashboardFunctions from '../../../../shared/components/DashboardFunctions';
import DashboardFunctionModel from '../../../../shared/models/DashboardFunctionModel';

export default {
  name: 'ReceptionistDashboardMobileContainer',
  components: { DashboardFunctions, RouteScreen, AppBackground },
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
  computed: {
    functions() {
      return [
        new DashboardFunctionModel(
          'Zarządzanie rejestracją',
          this.$fosGenerate('front.receptionist.register_management'),
          '/images/patient-dashboard/referral.png',
        ),
        new DashboardFunctionModel(
          'Zarządzanie wizytami',
          this.$fosGenerate('front.receptionist.appointment_management'),
          '/images/patient-dashboard/appointment.png',
        ),
        new DashboardFunctionModel(
          'Ustawienia',
          this.$fosGenerate('front.receptionist.settings'),
          '/images/patient-dashboard/settings.png',
        ),
      ];
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
