<template>
  <v-row row>
    <v-col md="4">
      <h1 class="text-h4 route-white mb-2">
        {{ header }}
      </h1>

      <p class="route-white">
        {{ text }}
      </p>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'RouteScreen',
  props: {
    header: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
.route {
  &-white {
    color: #fff;
  }
}

::v-deep .col {
  position: relative;
}
</style>
