<template>
  <div class="form-group">
    <label>
      {{ label }}
      <small v-if="required">*</small>
    </label>

    <QuillEditor :value="modelValue" theme="snow"
        @input="$emit('update:modelValue', $event.target.value)"
     />
     <small class="text-danger"
           v-if="errorText!==''">* {{ errorText }}
    </small>
  </div>
</template>

<script>
    import { QuillEditor } from "@vueup/vue-quill"
    import '@vueup/vue-quill/dist/vue-quill.snow.css';
    import '@vueup/vue-quill/dist/vue-quill.bubble.css';

  export default {
    name: "TextEditor",

    components: {
      QuillEditor,
    },

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

    data() {
      return {
        
      }
    },

    computed: {
    }
  }
</script>

<style scoped>

</style>