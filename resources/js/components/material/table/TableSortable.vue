<template>
  <div>
    <div class="form-group" v-if="searchUrl">
      <div class="row">
        <div :class="keyword.trim().length > 0 ? 'col-md-11' : 'col-md-12'">
          <input
            type="text"
            id="search"
            class="form-control no-border"
            :placeholder="searchPlaceHolder"
            v-model="keyword"
          />
        </div>
        <div class="col-md-1" v-if="keyword.trim().length > 0">
          <button
            type="button"
            class="
              btn btn-outline-warning btn-sm btn-rounded btn-ajax
              action-delete
            "
            @click="reset"
          >
            <i class="ti-reload btn-icon-prepend"></i>
          </button>
        </div>
      </div>
    </div>

    <app-sortable-list
      lockAxis="y"
      :useDragHandle="true"
      v-model="rows.data"
      v-on="listeners"
    >
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th v-if="sortable">
                <span class="material-icons">open_with</span>
              </th>
              <th v-else>SN</th>
              <th v-for="(column, index) in columns" :key="index">
                {{ column }}
              </th>
              <th v-if="actions">Actions</th>
              <th v-if="multiDelete"></th>
            </tr>
          </thead>

          <tbody v-if="filteredRows.data.length > 0 && keyword.length !== 0">
            <tr
              v-for="(row, index) in filteredRows.data"
              :disabled="!sortable"
              :index="index"
              :key="index"
              :item="row"
            >
              <td width="50" v-if="sortable" v-handle>
                <span class="handle material-icons">drag_handle</span>
              </td>
              <td width="20" class="text-center" v-else>
                {{
                  filteredRows.meta.from
                    ? filteredRows.meta.from + index
                    : ++index
                }}
              </td>
              <slot name="rowData" v-bind:row="row"></slot>
              <td v-if="multiDelete">
                <div class="checkbox">
                  <label>
                    <input
                      type="checkbox"
                      title="Check to delete"
                      :value="row.id"
                      v-model="deletableIds"
                      multiple
                    />
                  </label>
                </div>
              </td>
            </tr>
            <tr v-if="filteredRows.data.length === 0">
              <td colspan="3">No data available.</td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr
              v-for="(row, index) in innerRows.data"
              :disabled="!sortable"
              :index="index"
              :key="index"
              :item="row"
            >
              <td width="50" v-if="sortable" v-handle>
                <span class="handle material-icons">drag_handle</span>
              </td>
              <td width="20" class="text-center" v-else>
                {{
                  innerRows.meta.from ? innerRows.meta.from + index : ++index
                }}
              </td>
              <slot name="rowData" v-bind:row="row"></slot>
              <td v-if="multiDelete">
                <div class="checkbox">
                  <label>
                    <input
                      type="checkbox"
                      title="Check to delete"
                      :value="row.id"
                      v-model="deletableIds"
                      multiple
                    />
                  </label>
                </div>
              </td>
            </tr>
            <tr v-if="innerRows.data.length === 0">
              <td colspan="3">No data available.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- <button
        class="btn btn-danger"
        title="Delete Selected"
        v-if="deletableIds.length > 0"
        @click.prevent="$emit('deleteMultiple', deletableIds)"
      >
        Delete
      </button> -->
    </app-sortable-list>

    <div class="mt-4" v-if="paginate">
      <app-pagination
        v-model:rows="innerRows"
        v-if="keyword.length === 0"
      ></app-pagination>

      <app-pagination
        v-model:rows="filteredRows"
        v-if="keyword.length > 0 && filteredRows.links"
        :search="keyword"
      ></app-pagination>
    </div>
  </div>
</template>

<script>
import { HandleDirective } from "vue-slicksort";

export default {
  name: "TableSortable",

  directives: { handle: HandleDirective },

  data() {
    return {
      orderHasChanged: false,
      innerRows: { data: [], links: {}, meta: {} },
      filteredRows: { data: [], links: {}, meta: {} },
      keyword: "",
      deletableIds: [],
      searchPlaceHolder: "Search ",
      clearSearch: false,
    };
  },

  props: {
    columns: {
      type: Array,
      required: true,
    },
    rows: {
      required: true,
    },
    searchUrl: {
      required: false,
    },
    searchHolder: {
      required: false,
    },
    clearKeyword: {
      required: false,
      type: Boolean,
      default: false,
    },
    word: {
      required: false,
    },
    sortable: {
      type: Boolean,
      default: false,
    },
    paginate: {
      type: Boolean,
      default: true,
    },
    actions: {
      type: Boolean,
      default: true,
    },
    multiDelete: {
      default: false,
    },
  },

  methods: {
    searchRows() {
      if (this.searchUrl) {
        axios.get(this.searchUrl + this.keyword).then((response) => {
          try {
            if (response.data.data.length > 0) {
              this.filteredRows.data = response.data.data;
              this.filteredRows.meta = response.data.meta;
              this.filteredRows.links = response.data.links;
            }
          } catch (error) {}
        });
      }
    },
    reset() {
      this.keyword = "";
      this.filteredRows = { data: [], links: {}, meta: {} };
    },
  },

  computed: {
    listeners() {
      return {
        ...this.$listeners,
        "sort-end": ({ event, oldIndex, newIndex }) => {
          this.orderHasChanged = oldIndex !== newIndex;
        },
        input: (payload) =>
          this.orderHasChanged ? this.$emit("orderHasChanged", payload) : "",
      };
    },
  },

  mounted() {
    this.innerRows = this.rows;

    if (this.word) {
      setTimeout(() => {
        this.keyword = this.word;
        this.searchRows();
      }, 5000);
    }

    if (this.searchHolder) {
      this.searchPlaceHolder = this.searchHolder;
    }
  },

  watch: {
    rows(newVal) {
      this.innerRows = newVal;
    },
    keyword: function (val) {
      this.clearSearch = false;

      if (val.length > 0) {
        this.searchRows();
      } else {
        this.filteredRows.data = this.rows.data;
        this.filteredRows.meta = this.rows.meta;
        this.filteredRows.links = this.rows.links;
      }
    },
    "rows.data": function (val) {
      if (!this.sortable) {
        this.keyword = "";
      }
    },
    clearKeyword: function (val) {
      this.clearSearch = this.clearKeyword;
    },
    clearSearch: function (val) {
      if (val === true) {
        this.keyword = "";
      }
    },
  },
};
</script>

<style scoped>
.root {
  position: relative;
  margin-bottom: 20px;
}

.handle {
  opacity: 0.25;
  cursor: row-resize;
  /*line-height : 50px;*/
}

.list {
  min-height: auto;
}

.list-title {
  padding: 10px 15px;
  margin: 0;
  font-weight: 400;
  /*background-color : #DDDDDD;*/
  color: #666666;
}

.no-border {
  border-top: none;
  border-left: none;
  border-right: none;
  padding: 0 !important;
  height: 30px !important;
}
</style>
