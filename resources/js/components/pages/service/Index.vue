<template>
  <app-card title="All <b>Services</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="service.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/service/get-data/'"
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
        <td>
          <div
              class="badge badge-pill"
              :class="row.smart ? 'badge-success' : 'badge-danger'"
              :title="
                row.smart ? 'Smart Service' : 'Not Smart Service'
              "
            >
              <i
                :class="row.smart ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>
          <div
              class="badge badge-pill"
              :class="row.additional ? 'badge-success' : 'badge-danger'"
              :title="
                row.additional ? 'Additional Service' : 'Not Additional Service'
              "
            >
              <i
                :class="row.additional ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>
          <div
              class="badge badge-pill"
              :class="row.featured ? 'badge-success' : 'badge-danger'"
              :title="
                row.featured ? 'Featured Service' : 'Not Featured Service'
              "
            >
              <i
                :class="row.featured ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          <app-actions
            @deleteItem="deleteModel"
            :actions="{
              edit: { name: 'service.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import Service from "@utils/models/Service";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "ServiceIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Image",
        "Title",
        "Slug",
        "Icon",
        "Display",
        "Smart",
        "Additional",
        "Featured",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Service(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },
    reset() {
      axios.get("/admin/service").then((response) => {
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
