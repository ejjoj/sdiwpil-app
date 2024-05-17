<template>
  <v-form>
    <v-row wrap>
      <v-col
        md="6"
        cols="12"
      >
        <general-settings-part @change="handleSettingsChange" />
      </v-col>
      <v-col
        md="6"
        cols="12"
      >
        <professional-settings-part @change="handleSettingsChange" />
      </v-col>
      <v-col
        md="auto"
        cols="12"
      >
        <send-form-part @submit="saveSettings" />
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import axios from 'axios';
import { merge } from 'lodash';
import DoctorSettingsModel from '../models/DoctorSettingsModel';
import GeneralSettingsPart from '../../../../shared/components/Parts/GeneralSettingsPart';
import ProfessionalSettingsPart from './FormParts/ProfessionalSettingsPart';
import SendFormPart from './FormParts/SendFormPart';

export default {
  name: 'DoctorSettingsForm',
  components: { ProfessionalSettingsPart, GeneralSettingsPart, SendFormPart },
  data: () => ({
    settings: new DoctorSettingsModel(),
  }),
  methods: {
    handleSettingsChange(settings) {
      this.settings = merge(this.settings, settings);
    },
    async saveSettings() {
      try {
        const { data } = await axios.post(this.$fosGenerate('front.doctor.settings.save'), { ...this.settings });
        if (data.success) {
          this.$snotify.success('Pomyślnie zapisano ustawienia');
        } else {
          data.errors.forEach((error) => this.$snotify.error(error.message));
        }
      } catch (e) {
        console.error(`Doctor settings form error: ${e}`);
        this.$snotify.error('Coś poszło nie tak, przepraszamy');
      }
    },
  },
};
</script>

<style scoped>

</style>
