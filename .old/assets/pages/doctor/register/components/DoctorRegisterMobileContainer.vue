<template>
  <v-container
    :style="{
      paddingTop: `${navbarHeight}px`,
      minHeight: `calc(100vh - ${footerHeight}px)`,
    }"
  >
    <app-background color-schema="doctor" />

    <doctor-register-screen />

    <doctor-register-form />
  </v-container>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import DoctorRegisterScreen from './DoctorRegisterScreen';
import DoctorRegisterForm from './DoctorRegisterForm';

export default {
  name: 'DoctorRegisterMobileContainer',
  components: { AppBackground, DoctorRegisterScreen, DoctorRegisterForm },
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
