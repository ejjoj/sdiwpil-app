<template>
  <v-img
    src="/images/home-page/main.png"
    :width="height ? height : '100%'"
    :height="height"
    :class="[isOval && 'oval']"
  />
</template>

<script>
export default {
  name: 'MainImg',
  props: {
    height: {
      type: String,
      required: false,
      default: '',
    },
    isOval: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
};
</script>

<style scoped>
.oval {
  border-radius: 50%;
}
</style>
