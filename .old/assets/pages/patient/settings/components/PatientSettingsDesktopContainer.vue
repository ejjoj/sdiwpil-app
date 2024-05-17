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
        header="Ustawienia"
        text="Poniższy formularz udostępnia możliwość edycji danych dotyczących konta w systemie"
      />

      <patient-settings-form />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import PatientSettingsForm from './PatientSettingsForm';

export default {
  name: 'PatientSettingsDesktopContainer',
  components: { PatientSettingsForm, RouteScreen, AppBackground },
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

<style scoped lang="scss">
::v-deep {
  .background {
    z-index: 0;
  }
}
</style>
