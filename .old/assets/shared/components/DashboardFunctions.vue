<template>
  <v-row>
    <v-col
      v-for="({name, url, img}, i) in functions"
      :key="i"
      md="3"
    >
      <v-btn
        v-if="breakpoint.mdAndDown"
        block
        x-large
        color="accent"
        :href="url"
      >
        {{ name }}
      </v-btn>
      <v-card
        v-else
        :href="url"
      >
        <v-img
          height="250px"
          :src="img"
        />
        <v-card-title>{{ name }}</v-card-title>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import breakpoint from '../../mixins/breakpoint';

export default {
  name: 'DashboardFunctions',
  mixins: [breakpoint],
  props: {
    functions: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>

</style>
