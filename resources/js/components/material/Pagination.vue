<template>
  <ul
    class="pagination flex-wrap justify-content-center pagination-rounded"
    v-if="totalPages > 1"
  >
    <li class="page-item disabled" v-if="items.links.prev == null">
      <a class="page-link disabled-link" href="#"
        ><i class="ti-angle-left"></i
      ></a>
    </li>

    <li class="page-item" v-else>
      <a
        class="page-link"
        href="#"
        rel="prev"
        @click="goToUrl(items.links.prev, $event)"
        ><i class="ti-angle-left"></i
      ></a>
    </li>

    <li
      class="page-item"
      :class="items.meta.current_page == number ? 'active' : ''"
      v-for="(number, index) in totalPages"
      :key="index"
    >
      <a
        href="#"
        class="page-link disabled-link disabled"
        v-if="items.meta.current_page == number"
        >{{ number }}</a
      >
      <a
        class="page-link"
        href="#"
        v-else
        @click="goToUrl(items.meta.path + '?page=' + number, $event)"
        >{{ number }}</a
      >
    </li>

    <li class="page-item" v-if="items.links.next != null">
      <a
        class="page-link"
        href="#"
        rel="next"
        @click="goToUrl(items.links.next, $event)"
        ><i class="ti-angle-right"></i
      ></a>
    </li>

    <li class="page-item disabled" v-else>
      <a class="page-link disabled-link" href="#"
        ><i class="ti-angle-right"></i
      ></a>
    </li>
  </ul>
</template>

<script>
export default {
  name: "Pagination",
  props: {
    rows: {
      required: true,
    },
    search: "",
  },

  data() {
    return {
      items: [],
      searchParams: {},
    };
  },

  methods: {
    goToUrl(url, event) {
      event.preventDefault();
      url = url + this.searchQuery;
      this.getData(url);
    },

    getData(url) {
      axios
        .get(url)
        .then((response) => {
          this.$emit("update:rows", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  computed: {
    totalPages() {
      if (this.items.length === 0) return 1;

      return Math.ceil(this.items.meta.total / this.items.meta.per_page);
    },

    searchQuery() {
      return '';
      // if (this.search) {
      //   return "&" + this.search;
      // } else {
      //   return "";
      // }
    },
  },

  mounted() {
    this.items = this.rows;
    //console.log(this.items);
    // this.searchParams = this.search;
  },

  watch: {
    rows(value) {
      this.items = value;
    },
  },
};
</script>

<style scoped>
.disabled-link {
  background-color: #ededed !important;
  color: #908888 !important;
}
</style>