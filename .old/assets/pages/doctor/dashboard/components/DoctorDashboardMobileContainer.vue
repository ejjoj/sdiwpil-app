<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="doctor" />

    <route-screen
      header="Witaj w panelu lekarza"
      text="Skorzystaj z usług oferowanych przez konto lekarza poprzez kliknięcie w wybrany odnośnik."
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
  name: 'DoctorDashboardMobileContainer',
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
          'Wizyty',
          this.$fosGenerate('front.doctor.appointments'),
          '/images/patient-dashboard/appointment.png',
        ),
        new DashboardFunctionModel(
          'Zarządzanie wiadomościami',
          this.$fosGenerate('front.doctor.chats'),
          '/images/patient-dashboard/chat.png',
        ),
        new DashboardFunctionModel(
          'Zarządzanie dokumentami',
          this.$fosGenerate('front.doctor.documents'),
          '/images/patient-dashboard/referral.png',
        ),
        new DashboardFunctionModel(
          'Ustawienia',
          this.$fosGenerate('front.doctor.settings'),
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
