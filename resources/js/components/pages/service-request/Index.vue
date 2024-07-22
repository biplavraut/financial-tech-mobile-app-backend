<template>
  <app-card title="All <b>Service Requests</b>" body-padding="0">
    <!-- <template #actions>
      <app-btn-link route-name="branch.create" background="bibaabo">Add New</app-btn-link>
    </template> -->

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/service-request/get-data/'"
    >
      <template #rowData="{ row }">
        <td>
          <router-link
              :to="{
                name: 'kyc.view',
                params: { id: row.kyc.id },
              }"
                tag="button"
                class="btn btn-outline-primary btn-sm mb-2"
                title="View Detail"
                target="_blank"
              >
                {{ row.kyc.kycCode }}
              </router-link>
           </td>
        <td>{{ row.title }} </td>
        <td>{{ row.type }}</td>
        <td>
          {{ row.user.name }} <br> {{ row.user.mobile }}
        </td>
        
        
          <td>
            {{ row.status }}
          </td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          <router-link
            :to="{
              name: 'serviceRequest.view',
              params: { id: row.id },
            }"
              tag="button"
              class="btn btn-outline-primary btn-sm mb-2"
              title="View Detail"
            >
              View
            </router-link>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import ServiceRequest from "@utils/models/ServiceRequest";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "ServiceRequestIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "KYC Code",
        "Title",
        "Type",
        "User",
        "Status",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new ServiceRequest(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },

    reset() {
      axios.get("/admin/service-request").then((response) => {
        this.rows.data = response.data.data;
      });
    },
  },
  // setup() {
    
  // },

  mounted() {
    this.getModels();
  },
};
</script>

<style scoped></style>
