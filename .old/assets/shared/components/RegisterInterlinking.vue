<template>
  <v-row class="pt-4">
    <v-col
      md="3"
      cols="12"
    >
      <v-row>
        <v-col
          class="interlinking-column"
          cols="12"
        >
          Nie masz konta w systemie?
        </v-col>
        <v-col
          v-for="({ route, name, color }, key) in buttons"
          :key="key"
          class="interlinking-column"
          cols="12"
        >
          <v-btn
            :href="route"
            :color="color"
            class="interlinking-button"
          >
            {{ name }}
          </v-btn>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
import { get } from 'lodash';

export default {
  name: 'RegisterInterlinking',
  computed: {
    buttons() {
      return get(window, 'state.register_interlinking', []);
    },
  },
};
</script>

<style scoped>
.interlinking-button {
  color: #fff;
}

.interlinking-column {
  padding: 6px 12px;
}
</style>
