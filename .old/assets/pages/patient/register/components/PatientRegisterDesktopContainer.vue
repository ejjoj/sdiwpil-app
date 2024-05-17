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
      <patient-register-screen />

      <v-row justify="center">
        <v-col md="4">
          <patient-register-form />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import PatientRegisterScreen from './PatientRegisterScreen';
import PatientRegisterForm from './PatientRegisterForm';

export default {
  name: 'PatientRegisterDesktopContainer',
  components: { PatientRegisterScreen, AppBackground, PatientRegisterForm },
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

</style>
