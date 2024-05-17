<template>
  <v-card>
    <v-card-actions>
      <v-btn
        block
        color="primary"
        @click="$emit('submit')"
      >
        Zapisz ustawienia
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'SendFormPart',
};
</script>

<style scoped>

</style>
