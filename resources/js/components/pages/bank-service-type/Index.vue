<template>
  <app-card title="All <b>Bank Service Types</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="bankServiceType.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/bank-service-type/get-data/'"
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
              edit: { name: 'bankServiceType.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import BankServiceType from "@utils/models/BankServiceType";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { useRoute } from 'vue-router';

export default {
  name: "BankServiceTypeIndex",

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
      model: new BankServiceType(),
      allCount: 0,
      route: "",
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },

    getData() {
      axios.get("/admin/bank/bank-service-type/" + this.route.params.bank).then((response) => {
        this.rows.data = response.data.data;
      });
    },
    reset() {
      axios.get("/admin/bank/bank-service-type").then((response) => {
        this.rows.data = response.data.data;
      });
    },
  },

  mounted() {
    this.route = useRoute();
    // Now you can access params like:
    //console.log(this.route.params.bank);
    this.getData();
  },
};
</script>

<style scoped></style>
