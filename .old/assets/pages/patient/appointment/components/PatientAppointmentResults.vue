<template>
  <v-row dense>
    <v-col
      v-for="({id, firstName, secondName, lastName, email, doctorData}, i) in doctors"
      :key="i"
      cols="12"
    >
      <v-card
        :class="[chosenDoctor && chosenDoctor.id === id && 'active']"
        color="#00cec80d"
        @click="handleChosenDoctorChange({id, firstName, secondName, lastName, email, doctorData})"
      >
        <v-card-title class="text-h5">
          {{ firstName }} {{ secondName }} {{ lastName }}
        </v-card-title>

        <v-card-subtitle>{{ getDoctorExtraInfo(doctorData, email) }}</v-card-subtitle>

        <v-card-actions>
          <v-btn @click="handleChosenDoctorChange({id, firstName, secondName, lastName, email, doctorData})">
            Wybierz
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'PatientAppointmentResults',
  props: {
    doctors: {
      type: Array,
      required: true,
    },
  },
  data: () => ({
    chosenDoctor: null,
  }),
  methods: {
    handleChosenDoctorChange(doctor) {
      this.chosenDoctor = doctor;
      this.$emit('change', doctor);
    },
    getDoctorExtraInfo(doctorData, email) {
      return `${doctorData.medicalSpecialty.title}, ${email}`;
    },
  },
};
</script>

<style scoped lang="scss">
@import "assets/styles/colors";

.active {
  border: 3px solid #00cec8 !important;
}
</style>
