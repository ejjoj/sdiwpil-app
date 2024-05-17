<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="doctor" />

    <route-screen
      header="Ustawienia"
      text="W poniższym formularzu możesz edytować informacje dotyczące twojego konta"
    />

    <doctor-settings-form />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DoctorSettingsForm from './DoctorSettingsForm';

export default {
  name: 'DoctorSettingsMobileContainer',
  components: { AppBackground, RouteScreen, DoctorSettingsForm },
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
