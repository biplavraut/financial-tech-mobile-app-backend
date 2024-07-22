<template>
  <div class="form-group">
    <label>
      {{ label }}
      <small v-if="required">*</small>
    </label>
    <textarea class="form-control"
      :value="modelValue" theme="snow"
        @input="$emit('update:modelValue', $event.target.value)"
              v-bind="$attrs"
              v-html="value" cols="100" rows="15"></textarea>
    <small class="text-danger"
           v-if="errorText!==''">* {{ errorText }}
    </small>
  </div>
</template>

<script>
  export default {
    name: "InputTextarea",

    inheritAttrs: false,

    props: {
      modelValue: String,
      value: {
        type: String
      },
      required: {
        type: Boolean,
        default: false
      },
      label: {
        type: String,
        required: true
      },
      errorText: {
        type: String,
        default: ""
      }
    },
    emits: ['update:modelValue'],
  };
</script>
