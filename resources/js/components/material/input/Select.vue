<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <select class="form-control" @change="$emit('update:modelValue', $event.target.value)" v-bind="$props">
      <option value v-if="firstOption">Select {{ label }}</option>
      <option
        :data-tokens="dataTokens"
        :value="option.id"
        v-for="(option, index) in options"
        :key="index"
        :selected="option.id == value"
      >
        {{ option.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "Select",

  props: {
    modelValue: String,
    value: {},
    label: {
      type: String,
      required: false,
    },
    options: {
      type: Array,
      required: true,
    },
    dataLiveSearch: { default: true },
    dataTokens: { type: String, default: "" },
    dataSize: { default: 5 },
    firstOption: { type: Boolean, default: true },
  },

  emits: ['update:modelValue'],

  methods: {
    emitEvent(event) {
      this.$emit("input", event.target.value);
    },
  },

  watch: {
    options(val) {
      //refreshSelectPicker(200);
    },
  },

  mounted() {
    let self = this;
    $(document).on("keyup", ".bs-searchbox input", function () {
      self.$emit("typing", $(this).val());
    });
  },
};
</script>

<style scoped>
.inline {
  display: inline-block;
  margin-right: 10px;
  margin-top: 0;
  padding-bottom: 0;
}
</style>