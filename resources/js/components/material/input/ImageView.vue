<template>
  <div class="show-image-on-hover">
    <label>
      <span
        class="material-icons"
        style="position: absolute; top: 0; left: -10px"
        >remove_red_eye</span
      >
    </label>
    <img :src="value" style="display: none" />
  </div>
</template>

<script>
export default {
  name: "ImageView",

  props: {
    value: {},
  },

  data() {
    return {
      showDelete: false,
      imageFile: "",
      imageUrlInside: "",
    };
  },

  methods: {},

  computed: {},

  mounted() {},

  watch: {},
};
</script>

<style scoped
       lang="scss">
.show-image-on-hover:hover img {
  display: block !important;
  position: absolute;
  z-index: 1;
  width: 200px;
  height: 200px;
}
</style>