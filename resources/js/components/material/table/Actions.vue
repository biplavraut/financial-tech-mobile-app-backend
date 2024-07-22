<template>
  <div>
    <slot name="first"></slot>
    <router-link
      v-if="actions.hasOwnProperty('edit')"
      :to="actions.edit"
      tag="button"
      class="btn btn-outline-success btn-sm"
      title="Edit"
    >
      Edit <i class="material-icons">edit</i>
    </router-link>

    <button
      v-if="actions.hasOwnProperty('delete')"
      type="button"
      class="btn btn-outline-danger btn-sm btn-ajax action-delete"
      data-toggle="modal"
      data-target="#index-delete-model"
      :data-id="actions.delete"
      @click.prevent="selectItemToDelete(actions.delete)"
      title="Delete"
    >
      Delete <i class="material-icons">close</i>
    </button>
    <slot name="last"></slot>
  </div>
</template>

<script>
export default {
  name: "Actions",

  props: ["actions"],

  methods: {
    selectItemToDelete(itemId) {
      this.$emit("deleteItem", itemId);
    },
  },
};
</script>

<style scoped>
.btn{
  margin-right: 10px !important;
}
</style>