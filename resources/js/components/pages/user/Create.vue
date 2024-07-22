<template>
  <div>
    <h1>hi</h1>
  </div>
</template>

<script>
import User from "@utils/models/User";
// import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { mapGetters } from "vuex";

export default {
  name: "UserIndex",

  mixins: [index, destroy],

  data() {
    return {};
  },

  methods: {},
  created() {},
  mounted() {},
  computed: {
    ...mapGetters(["authUser"]),
  },
  watch: {},
};
</script>

<style scoped>
.cursor {
  cursor: pointer;
}
</style>
