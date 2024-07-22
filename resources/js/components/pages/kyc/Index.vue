<template>
  <app-card title="All <b>KYCs</b>" body-padding="0">
    <!-- <template #actions>
      <app-btn-link route-name="branch.create" background="bibaabo">Add New</app-btn-link>
    </template> -->

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/kyc/get-data/'"
    >
      <template #rowData="{ row }">
        <td width="100">
            <img
              :src="row.ppPhoto"
              style="width: 50px; height: 50px; border-radius: 50%"
            />
          </td>
        <td>{{ row.kycCode }} </td>
        <td>{{ row.phone }} <br> {{ row.mobile }}</td>
        <td>
          {{ row.user.name }} <br> {{ row.user.phone }}
        </td>
        
        <td>
          <div
              >
              <i
                :class="row.self ? 'badge-success' : 'badge-warning'"
              > {{ row.self ? "self" : "other"}}</i>
            </div>
        </td>

        <td>
            <div
                class="badge badge-pill"
                :class="row.kycVerified ? 'badge-success' : 'badge-danger'"
                :title="row.kycVerified ? 'Verified' : 'Not Verified'
                  "
              >
                <i
                  :class="row.kycVerified ? 'ti-check' : 'ti-close'"
                ></i>
              </div>
          </td>
          <td>
            {{ row.status }}
          </td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          <router-link
            :to="{
              name: 'kyc.view',
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
import Kyc from "@utils/models/Kyc";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";

export default {
  name: "KycIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "PP Photo",
        "KYC Code",
        "Contact",
        "Added By",
        "Created For",
        "KYC Verified",
        "Status",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Kyc(),
      allCount: 0,
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },

    reset() {
      axios.get("/admin/kyc").then((response) => {
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
