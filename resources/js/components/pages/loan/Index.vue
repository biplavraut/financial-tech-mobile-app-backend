<template>
  <app-card title="All <b>Loan Types</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="loan.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/loan/get-data/'"
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
        <td><img
            :src="row.icon"
            style="width: 50px; height: 50px; border-radius: 50%"
          /></td>
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
              edit: { name: 'loan.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import Loan from "@utils/models/Loan";

import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "AccountIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Image",
        "Title",
        "Slug",
        "Icon",
        "Display",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Loan(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },
    reset() {
      axios.get("/admin/loan").then((response) => {
        this.rows.data = response.data.data;
      });
    },
  },

  mounted() {
    this.getModels();
  },
};
</script>

<style scoped></style>
