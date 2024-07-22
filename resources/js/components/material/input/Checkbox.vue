<template>
  <div class="form-group">
    <div :class="'form-check form-check-' + color">
      <label class="form-check-label"
        ><input
          type="checkbox"
          class="form-check-input"
          :checked="modelValue"
          v-bind="$attrs"
          :required="required"
          @input="$emit('update:modelValue', $event.target.checked)"
           />
        {{ label }}
        <i class="input-helper"></i
      ></label>
    </div>
  </div>
</template>

<script>
export default {
  name: "Checkbox",

  inheritAttrs: false,

  props: {
    modelValue: Boolean,
    value: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: "",
    },
    color: {
      type: String,
      default: "bibaabo",
    },
  },

  emits: ['update:modelValue'],

  computed: {
    // listeners() {
    //   return {
    //     ...this.$listeners,
    //     input: (event) => $emit('update:modelValue', $event.target.checked),
    //   };
    // },
  },
};
</script>
