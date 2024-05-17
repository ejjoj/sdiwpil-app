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
      <route-screen
        header="Witaj w panelu pacjenta"
        text="Skorzystaj z usług oferowanych przez konto w systemie. Poniżej znajdują się odnośniki do poszczególnych sekcji."
      />

      <dashboard-functions :functions="functions" />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import DashboardFunctions from '../../../../shared/components/DashboardFunctions';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DashboardFunctionModel from '../../../../shared/models/DashboardFunctionModel';

export default {
  name: 'PatientDashboardDesktopContainer',
  components: {
    RouteScreen,
    DashboardFunctions,
    AppBackground,
  },
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
          'Dokumenty',
          this.$fosGenerate('front.patient.documents'),
          '/images/patient-dashboard/referral.png',
        ),
        new DashboardFunctionModel(
          'Wizyty',
          this.$fosGenerate('front.patient.appointment'),
          '/images/patient-dashboard/appointment.png',
        ),
        new DashboardFunctionModel(
          'Czat z lekarzem',
          this.$fosGenerate('front.patient.chat'),
          '/images/patient-dashboard/chat.png',
        ),
        new DashboardFunctionModel(
          'Ustawienia',
          this.$fosGenerate('front.patient.settings'),
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
