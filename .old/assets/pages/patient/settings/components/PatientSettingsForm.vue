<template>
  <v-form>
    <v-row wrap>
      <v-col
        md="6"
        cols="12"
      >
        <general-settings-part @change="setSettingsChange" />

        <v-btn
          color="primary"
          class="mt-4"
          :loading="loading"
          :disabled="loading"
          @click="saveSettings"
        >
          Zapisz ustawienia
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import axios from 'axios';
import GeneralSettingsPart from '../../../../shared/components/Parts/GeneralSettingsPart';
import UserSettingsModel from '../../../../shared/models/UserSettingsModel';

export default {
  name: 'PatientSettingsForm',
  components: { GeneralSettingsPart },
  data: () => ({
    settings: new UserSettingsModel(),
    loading: false,
  }),
  methods: {
    setSettingsChange(settings) {
      this.settings = settings;
    },
    async saveSettings() {
      this.loading = true;
      try {
        const { data } = await axios.post(this.$fosGenerate('front.patient.settings.save'), { ...this.settings });
        if (data.success) {
          this.$snotify.success('Pomyślnie zapisano ustawienia');
        } else {
          data.errors.forEach((error) => this.$snotify.error(error.message));
        }
      } catch (e) {
        this.$snotify.error('Coś poszło nie tak, spróbuj ponownie');
        console.error(`Patient save settings error: ${e}`);
      }
      this.loading = false;
    },
  },
};
</script>

<style scoped>

</style>
