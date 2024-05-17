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
        header="Tworzenie dokumentów medycznych"
        text="Poniższa lista przedstawia wystawione w systemie dokumenty medyczne."
      />

      <doctor-documents-list />
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import RouteScreen from '../../../../shared/components/RouteScreen';
import DoctorDocumentsList from './DoctorDocumentsList';

export default {
  name: 'DesktopContainer',
  components: { DoctorDocumentsList, AppBackground, RouteScreen },
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

.container {
  position: relative;
}
</style>
