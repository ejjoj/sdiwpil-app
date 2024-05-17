<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background />

    <patient-register-screen />

    <patient-register-form />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import PatientRegisterScreen from './PatientRegisterScreen';
import PatientRegisterForm from './PatientRegisterForm';

export default {
  name: 'PatientRegisterMobileContainer',
  components: { AppBackground, PatientRegisterScreen, PatientRegisterForm },
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
