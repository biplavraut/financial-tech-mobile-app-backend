<template>
  <app-card title="All <b>Banners</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="banner.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/banner/get-data/'"
    >
      <template #rowData="{ row }">
        <td width="100">
          <img
            :src="row.image"
            style="width: 50px; height: 50px; border-radius: 50%"
          />
        </td>
        <td>{{ row.title }}</td>
        <td>{{ row.subTitle }}</td>
        <td>{{ row.page }}</td>
        <td>{{ row.feature }}</td>
        <td>{{ row.link ? row.link : "-" }}</td>
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
              edit: { name: 'banner.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import Banner from "@utils/models/Banner";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "BannerIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Image",
        "Title",
        "Sub Title",
        "Page",
        "Feature",
        "Link",
        "Display",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Banner(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },
    reset() {
      axios.get("/admin/banner").then((response) => {
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
