const breakpoint = {
  data: () => ({
    isHydrated: false,
  }),
  computed: {
    breakpoint() {
      return this.isHydrated && this.$vuetify.breakpoint || {};
    },
  },
  mounted() {
    this.isHydrated = true;
  },
};

export default breakpoint;
