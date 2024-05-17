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
      <doctor-register-screen />

      <v-row justify="center">
        <v-col md="4">
          <doctor-register-form />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import AppBackground from '../../../../shared/components/AppBackground';
import DoctorRegisterScreen from './DoctorRegisterScreen';
import DoctorRegisterForm from './DoctorRegisterForm';

export default {
  name: 'DoctorRegisterDesktopContainer',
  components: { DoctorRegisterScreen, AppBackground, DoctorRegisterForm },
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
