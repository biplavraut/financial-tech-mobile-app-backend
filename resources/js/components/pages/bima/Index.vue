<template>
  <app-card title="All <b>Bima</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="bima.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/bima/get-data/'"
    >
      <template #rowData="{ row }">
        <td width="100">
          <img
            :src="row.logo"
            style="width: 50px; height: 50px; border-radius: 50%"
          />
        </td>
        <td>{{ row.title }}</td>
        <td>{{ row.routingNo }}</td>
        <td>{{ row.phone }} <br> {{ row.mobile }}</td>
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
              :class="row.featured ? 'badge-success' : 'badge-danger'"
              :title="
                row.featured ? 'Featured Bank' : 'Not Featured Bank'
              "
            >
              <i
                :class="row.featured ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>{{ row.rating }}</td>
        <td>{{ row.type }}</td>
        <td>{{ row.address }}</td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          
          <!-- <router-link
          :to="{
            name: 'branch.list',
            params: { bima: row.id },
          }"
            tag="button"
            class="btn btn-outline-primary btn-sm mb-2"
            title="Branches"
          >
            Branches
          </router-link>
          <router-link
            :to="{
              name: 'bankAccountType.list',
              params: { bima: row.id },
            }"
              tag="button"
              class="btn btn-outline-primary btn-sm mb-2"
              title="Bank Account Types"
            >
              Account Types
            </router-link> -->
          <app-actions
            @deleteItem="deleteModel"
            :actions="{
              edit: { name: 'bima.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
          <router-link
            :to="{
              name: 'bimaAccountType.list',
              params: { bima: row.id },
            }"
              tag="button"
              class="btn btn-outline-primary btn-sm"
              title="Bima Account Types"
            >
              Account Types
            </router-link>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import Bima from "@utils/models/Bima";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "BimaIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Logo",
        "Title",
        "Routing no",
        "Contact",
        "Display",
        "Featured",
        "Rating",
        "Type",
        "Address",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Bima(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLL");
    },
    reset() {
      axios.get("/admin/bima").then((response) => {
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
