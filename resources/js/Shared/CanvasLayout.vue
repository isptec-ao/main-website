<script>
// import Main from "../layouts/main";
import Vertical from "../layouts/vertical";
import Horizontal from "../layouts/horizontal";

export default {
  name: 'BaseCanvasLayout',
  components: { Vertical, Horizontal },
  // components: { Main },
  data() {
    return {};
  },
  computed: {
    layoutType() {
        return this.$root.layout?.type;
    }
  },
  methods: {}
};
</script>

<template>
  <div>
    <vertical v-if="layoutType === 'vertical'">
      <slot />
    </vertical>

    <Horizontal v-if="layoutType === 'horizontal'">
      <slot />
    </Horizontal>
  </div>
</template>
