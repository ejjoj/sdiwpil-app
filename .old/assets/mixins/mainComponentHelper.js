const mainComponentHelper = {
  data: () => ({
    navbarHeight: 0,
    footerHeight: 0,
  }),
  mounted() {
    this.navbarHeight = this.getNavbarHeight();
    this.footerHeight = this.getFooterHeight();
  },
  methods: {
    getNavbarHeight() {
      const { navbar } = this.$refs;
      if (navbar) {
        const firstChild = navbar.$children[0];

        return firstChild.$el ? firstChild.$el.clientHeight + 12 : 0;
      }

      return 0;
    },
    getFooterHeight() {
      const { footer } = this.$refs;
      if (footer) {
        return footer.$el.clientHeight;
      }

      return 0;
    },
  },
};

export default mainComponentHelper;
