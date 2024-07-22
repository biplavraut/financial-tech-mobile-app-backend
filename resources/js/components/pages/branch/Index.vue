<template>
  <app-card title="All <b>Branches</b>" body-padding="0">
    <template #actions>
      <app-btn-link route-name="branch.create" background="bibaabo">Add New</app-btn-link>
    </template>

    <app-table-sortable
      :columns="columns"
      :rows="rows"
      :searchUrl="'/admin/branch/get-data/'"
    >
      <template #rowData="{ row }">
        <td>{{ row.title }} 
            <div
                class="badge badge-pill badge-success"
                title="Head Office"
                v-if="row.headOffice"
              >
              Head Office
              </div></td>
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
              :class="row.locker ? 'badge-success' : 'badge-danger'"
              :title="
                row.locker ? 'Locker Facility' : 'No Locker Facility'
              "
            >
              <i
                :class="row.locker ? 'ti-check' : 'ti-close'"
              ></i>
            </div>
        </td>
        <td>
            <div
                class="badge badge-pill"
                :class="row.atm ? 'badge-success' : 'badge-danger'"
                :title="row.atm ? 'ATM Available' : 'ATM Not Available'
                  "
              >
                <i
                  :class="row.atm ? 'ti-check' : 'ti-close'"
                ></i>
              </div>
          </td>
        <td>{{ formatDate(row.createdAt.date) }}</td>
        <td width="100">
          <app-actions
            @deleteItem="deleteModel"
            :actions="{
              edit: { name: 'branch.edit', params: { id: row.id } },
              delete: row.id,
            }"
          ></app-actions>
        </td>
      </template>
    </app-table-sortable>
  </app-card>
</template>

<script>
import Branch from "@utils/models/Branch";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { useRoute } from 'vue-router';

export default {
  name: "BranchIndex",

  mixins: [index, destroy],

  data() {
    return {
      columns: [
        "Title",
        "Contact",
        "Display",
        "Locker",
        "Atm",
        "Added On",
      ],
      rows: { data: [], links: {}, meta: {} },
      model: new Branch(),
      allCount: 0,
      route:"",
    };
  },

  methods: {
    formatDate(date) {
      return moment(date).format("LLLL");
    },
    getData(){
      axios.get("/admin/bank/branch/" + this.route.params.bank).then((response) => {
        this.rows.data = response.data.data;
      });
    },

    reset() {
      axios.get("/admin/bank/branch/"+ this.route.params.bank).then((response) => {
        this.rows.data = response.data.data;
      });
    },
  },
  // setup() {
    
  // },

  mounted() {
    this.route = useRoute();
    // Now you can access params like:
    //console.log(this.route.params.bank);
    this.getData();
  },
};
</script>

<style scoped></style>
