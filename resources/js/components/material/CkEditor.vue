<template>
  <div class="form-group">
    <label>
      {{ label }}
      <small v-if="required">*</small>
    </label>

    <ckeditor :value="value" v-bind="$attrs" v-on="listeners"> </ckeditor>

    <small class="text-danger" v-if="errorText !== ''"
      >* {{ errorText }}
    </small>
  </div>
</template>

<script>
import CKEditor from "ckeditor4-vue";

export default {
  name: "CkEditor",

  components: {
    ckeditor: CKEditor.component,
  },

  inheritAttrs: false,

  props: {
    value: {
      type: String,
    },
    required: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      required: true,
    },
    errorText: {
      type: String,
      default: "",
    },
  },

  data() {
    return {};
  },

  computed: {
    listeners() {
      return this.$listeners;
    },
  },
};
</script>

<style scoped>
</style>