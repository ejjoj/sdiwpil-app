<template>
  <div>
    <v-container fluid>
      <app-background color-schema="management" />
    </v-container>

    <v-container
      :style="{
        paddingTop: `${navbarHeight}px`,
        minHeight: `calc(100vh - ${footerHeight}px)`,
      }"
    >
      <route-screen
        header="Witaj w panelu administracji placówki medycznej"
        text="Poniższe odnośniki przestawiają możliwości oferowane przez system. Kliknij w jeden z nich, by rozpocząć akcję"
      />

      <dashboard-functions :functions="functions" />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DashboardFunctions from '../../../../shared/components/DashboardFunctions';
import DashboardFunctionModel from '../../../../shared/models/DashboardFunctionModel';

export default {
  name: 'DesktopContainer',
  components: { DashboardFunctions, AppBackground, RouteScreen },
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
          'Statystyki',
          this.$fosGenerate('front.management.statistics'),
          '/images/dashboard-functions/statistics.png',
        ),
        new DashboardFunctionModel(
          'Ustawienia',
          this.$fosGenerate('front.management.settings'),
          '/images/patient-dashboard/settings.png',
        ),
      ];
    },
  },
};
</script>

<style scoped>

</style>
