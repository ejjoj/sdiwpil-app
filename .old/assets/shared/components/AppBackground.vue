<template>
  <div :class="classes" />
</template>

<script>
export default {
  name: 'AppBackground',
  props: {
    colorSchema: {
      type: String,
      default: 'patient',
      validator: (value) => ['patient', 'doctor', 'receptionist', 'management'].includes(value),
    },
  },
  computed: {
    classes() {
      switch (this.colorSchema) {
        case 'doctor':
          return 'background background-doctor';
        case 'receptionist':
          return 'background background-receptionist';
        case 'management':
          return 'background background-management';
        default:
          return 'background';
      }
    },
  },
};
</script>

<style scoped lang="scss">
@import "assets/styles/app";

.background {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 150%;
  height: 360px;
  border-radius: 0 0 50% 50%;
  background: linear-gradient(180deg, $primary 0%, $secondary 100%);
  z-index: -1;

  @media (min-width: $md) {
    height: 460px;
  }

  &-doctor {
    background: linear-gradient(180deg, $secondary 0%, $primary 100%);
  }

  &-receptionist {
    background: linear-gradient(180deg, $accent 0%, $primary 100%);
  }

  &-management {
    background: linear-gradient(180deg, $success 0%, $warning 100%);
  }
}
</style>
