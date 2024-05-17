<template>
  <v-stepper v-model="step">
    <v-stepper-items>
      <v-stepper-content step="1">
        <patient-appointment-form @change="handleFormChange" />

        <v-btn
          v-show="showSearchButton"
          block
          x-large
          @click="findDoctor"
        >
          Szukaj
        </v-btn>
      </v-stepper-content>

      <v-stepper-content step="2">
        <patient-appointment-results
          class="mb-4"
          :doctors="doctors"
          @change="handleResultsChange"
        />

        <v-row>
          <v-col cols="auto">
            <v-btn
              text
              @click="step -= 1"
            >
              Wstecz
            </v-btn>
          </v-col>

          <v-spacer />

          <v-col cols="auto">
            <v-btn
              color="primary"
              :disabled="!chosenDoctor"
              :loading="isLoadingAppointmentDates"
              @click="findAppointmentDates"
            >
              Dalej
            </v-btn>
          </v-col>
        </v-row>
      </v-stepper-content>

      <v-stepper-content step="3">
        <patient-appointment-rest-info-form
          :appointment-dates="appointmentDates"
          @scheduledAtChange="handleScheduledAtChange"
          @patientReasonChange="handlePatientReasonChange"
        />

        <v-btn
          text
          @click="step -= 1"
        >
          Wstecz
        </v-btn>
        <v-btn
          color="primary"
          type="submit"
          class="mb-2"
          :loading="isLoadingRestInfoForm"
          :disabled="!isScheduledAtSet || !isPatientReasonSet"
          @click="createNewAppointment"
        >
          Potwierdź
        </v-btn>
      </v-stepper-content>
    </v-stepper-items>
  </v-stepper>
</template>

<script>
import axios from 'axios';
import PatientAppointmentForm from './PatientAppointmentForm';
import PatientAppointmentResults from './PatientAppointmentResults';
import PatientAppointmentRestInfoForm from './PatientAppointmentRestInfoForm';
import AppointmentSearchModel from '../models/AppointmentSearchModel';

export default {
  name: 'PatientAppointmentStepper',
  components: { PatientAppointmentForm, PatientAppointmentResults, PatientAppointmentRestInfoForm },
  data: () => ({
    step: 1,
    showSearchButton: false,
    search: new AppointmentSearchModel(),
    doctors: [],
    chosenDoctor: null,
    appointmentDates: [],
    isLoadingAppointmentDates: false,
    isLoadingRestInfoForm: false,
    scheduledAt: '',
    patientReason: '',
    isScheduledAtSet: false,
    isPatientReasonSet: false,
  }),
  methods: {
    handleFormChange(search) {
      const { medicalSpecialty, city, lastName } = search;
      this.showSearchButton = !!(medicalSpecialty || city || lastName);
      this.search = search;
    },
    handleResponseErrors(errors) {
      errors.forEach(({ message }) => this.$snotify.error(message));
    },
    handleAxiosError(error, action) {
      console.error(`${action} error: ${error}`);
      this.$snotify.error('Przepraszamy, coś poszło nie tak');
    },
    async findDoctor() {
      try {
        const { data } = await axios.post(this.$fosGenerate('front.patient.appointment.find_doctor'), { ...this.search });
        if (data.success) {
          this.doctors = data.doctors;
          this.step += 1;
        } else {
          this.handleResponseErrors(data.errors);
        }
      } catch (e) {
        this.handleAxiosError(e, 'Find doctor');
      }
    },
    handleResultsChange(doctor) {
      this.chosenDoctor = doctor;
    },
    async findAppointmentDates() {
      this.isLoadingAppointmentDates = true;
      try {
        const { data } = await axios.post(this.$fosGenerate('front.patient.appointment.find_appointment_dates'), { doctor: this.chosenDoctor.id });
        if (data.success) {
          this.appointmentDates = data.appointmentDates;
          this.step += 1;
        } else {
          this.handleResponseErrors(data.errors);
        }
      } catch (e) {
        this.handleAxiosError(e, 'Find appointment dates');
      }
      this.isLoadingAppointmentDates = false;
    },
    async createNewAppointment() {
      this.isLoadingRestInfoForm = true;
      try {
        const { scheduledAt, patientReason, chosenDoctor } = this;
        const payload = {
          scheduledAt,
          patientReason,
          doctor: chosenDoctor.doctorData.id,
        };
        const { data } = await axios.post(this.$fosGenerate('front.appointment.new'), payload);
        if (data.success) {
          this.$emit('appointmentsChange', data.appointments);
          this.$emit('closeModal');
          this.$snotify.success('Pomyślnie umówiono wizytę');
        } else {
          this.handleResponseErrors(data.errors);
        }
      } catch (e) {
        this.handleAxiosError(e, 'Create new appointment');
      }
      this.isLoadingRestInfoForm = false;
    },
    handleScheduledAtChange(scheduledAt) {
      this.scheduledAt = scheduledAt;
      this.isScheduledAtSet = true;
    },
    handlePatientReasonChange(patientReason) {
      this.patientReason = patientReason;
      this.isPatientReasonSet = true;
    },
  },
};
</script>

<style scoped>

</style>
