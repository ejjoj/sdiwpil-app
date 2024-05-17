<template>
  <v-row justify="center">
    <v-col
      v-for="({ image, title, description, url }, i) in functions"
      :key="i"
      cols="auto"
    >
      <function-card
        :image="image"
        :title="title"
        :description="description"
        :url="url"
      />
    </v-col>
  </v-row>
</template>

<script>
import FunctionCard from './FunctionCard';

export default {
  name: 'FunctionsBlock',
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
