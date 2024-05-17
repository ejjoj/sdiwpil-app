<template>
  <v-footer
    padless
  >
    <v-card
      flat
      tile
      width="100%"
      :color="color"
      class="text-center"
    >
      <v-card-text class="white--text">
        {{ year }} - <strong>SDIWPIL</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
export default {
  name: 'AppFooter',
  props: {
    colorSchema: {
      type: String,
      default: 'default',
      validator: (value) => ['default', 'receptionist', 'management'].includes(value),
    },
  },
  computed: {
    year() {
      return new Date().getFullYear();
    },
    color() {
      switch (this.colorSchema) {
        case 'receptionist':
          return 'primary';
        case 'management':
          return 'warning';
        default:
          return 'accent';
      }
    },
  },
};
</script>

<style scoped>

</style>
