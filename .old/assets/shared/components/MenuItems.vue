<template>
  <v-row>
    <v-col
      v-for="({ route, name }, key) in menuItems"
      :key="key"
      cols="auto"
    >
      <v-btn
        text
        color="white"
        :href="$fosGenerate(route)"
      >
        {{ name }}
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
import { get } from 'lodash';
import { mapState } from 'vuex';
import { MENU } from '../../store/module-namespaces';
import { ITEMS } from '../../store/module-state-properties';

export default {
  name: 'MenuItems',
  computed: {
    ...mapState(MENU, {
      items: ITEMS,
    }),
    /**
     * @deprecated
     * Due to the lack of time to prepare all modules for Vuex I'm forced to use this. TODO: delete this and use only
     * this.items
     */
    menuItems() {
      if (this.items) {
        return this.items;
      }

      return get(window, 'state.menu', []);
    },
  },
};
</script>

<style scoped>

</style>
