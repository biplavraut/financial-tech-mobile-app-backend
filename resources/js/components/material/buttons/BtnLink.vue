<template>
  <router-link
    :to="{ name: routeName }"
    class="btn btn-sm btn-icon-text title-right-action"
    :class="'btn-' + background"
  >
    <i class="material-icons">{{ icon }}</i>
    <slot>Btn Text</slot>
  </router-link>
</template>

<script>
export default {
  name: "BtnLink",

  props: {
    routeName: {
      type: String,
      default: "",
    },
    background: {
      type: String,
      default: "bibaabo",
    },
    icon: {
      type: String,
      default: "add_circle_outline",
    },
  },
};
</script>

<style scoped>
.title-right-action {
  right: 15px;
  top: 6px;
  margin-top: -10px;
  float: right;
  margin-left: 10px;
}
</style>