<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="management" />

    <route-screen
      header="Panel statystyk"
      text="Poniżej przedstawione są na wykresach statystyki. Skorzystaj z nich by odczytać najpotrzebniejsze dane."
    />

    <statistics-chart />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import StatisticsChart from './StatisticsChart';

export default {
  name: 'MobileContainer',
  components: { RouteScreen, AppBackground, StatisticsChart },
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
