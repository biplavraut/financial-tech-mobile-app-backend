<template>
  <app-card title="All <b>Bima Account Types</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="bimaAccountType.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/bima-account-type/get-data/'"
    >
      <template #rowData="{ row }">
        <td width="100">
          <img
            :src="row.image"
            style="width: 50px; height: 50px; border-radius: 50%"
          />
        </td>
        <td>{{ row.title }}</td>
        <td>{{ row.slug }}</td>
        
        <td>
          <div
              class="badge badge-pill"
              :class="row.display ? 'badge-success' : 'badge-danger'"
              :title="
                row.display ? 'Display' : 'Not Display'
              "
            >
              <i
                :class="row.display ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          <app-actions
            @deleteItem="deleteModel"
            :actions="{
              edit: { name: 'bimaAccountType.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import BimaAccountType from "@utils/models/BimaAccountType";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { useRoute } from 'vue-router';

export default {
  name: "BimaAccountTypeIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Image",
        "Title",
        "Slug",
        "Display",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new BimaAccountType(),
      allCount: 0,
      route: "",
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },

    getData() {
      axios.get("/admin/bima/bima-account-type/" + this.route.params.bima).then((response) => {
        this.rows.data = response.data.data;
      });
    },
    reset() {
      axios.get("/admin/bima/bima-account-type").then((response) => {
        this.rows.data = response.data.data;
      });
    },
  },

  mounted() {
    this.route = useRoute();
    // Now you can access params like:
    //console.log(this.route.params.bima);
    this.getData();
  },
};
</script>

<style scoped></style>
