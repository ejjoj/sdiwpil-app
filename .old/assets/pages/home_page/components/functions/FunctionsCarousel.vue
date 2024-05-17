<template>
  <v-carousel
    hide-delimiters
    light
    height="420"
  >
    <v-carousel-item
      v-for="({ title, description, image }, i) in functions"
      :key="i"
    >
      <function-card
        :image="image"
        :title="title"
        :description="description"
      />
    </v-carousel-item>
  </v-carousel>
</template>

<script>
import FunctionCard from './FunctionCard';

export default {
  name: 'FunctionsCarousel',
  components: { FunctionCard },
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
