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
        header="Witaj w panelu lekarza"
        text="Skorzystaj z usług oferowanych przez konto lekarza poprzez kliknięcie w wybrany odnośnik."
      />

      <dashboard-functions :functions="functions" />
    </v-container>
  </div>
</template>

<script>
import DashboardFunctionModel from '../../../../shared/models/DashboardFunctionModel';
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DashboardFunctions from '../../../../shared/components/DashboardFunctions';

export default {
  name: 'DoctorDashboardDesktopContainer',
  components: { AppBackground, RouteScreen, DashboardFunctions },
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

<style scoped lang="scss">
::v-deep {
  .background {
    z-index: 0;
  }
}
</style>
