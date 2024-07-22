<template>
  <app-card title="All <b>Service Provider</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="service-provider.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/service-provider/get-data/'"
    >
      <template #rowData="{ row }">
        <td width="100">
          <img
            :src="row.logo"
            style="width: 50px; height: 50px; border-radius: 50%"
          />
        </td>
        <td :title="row.address">{{ row.title }}</td>
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
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          
          <!-- <router-link
          :to="{
            name: 'branch.list',
            params: { bank: row.id },
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
              params: { bank: row.id },
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
              edit: { name: 'service-provider.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import ServiceProvider from "@utils/models/ServiceProvider";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "ServiceProviderIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Logo",
        "Title",
        "Contact",
        "Display",
        "Featured",
        "Rating",
        "Type",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new ServiceProvider(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLL");
    },
    reset() {
      axios.get("/admin/service-provider").then((response) => {
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
