<template>
  <!-- <div class="card card-stats">
    <div class="card-header"
         :data-background-color="info.backgroundColor||'blue'">
      <i class="material-icons">{{ info.icon||'person' }}</i>
    </div>
    <div class="card-content">
      <p class="category">{{ info.name }}</p>
      <h3 class="card-title">{{ info.title }}</h3>
    </div>
    <router-link class="card-footer"
                 :class="{'cursor-pointer hover-effect':info.url}"
                 tag="div"
                 :to="info.url || {}">
      <div class="stats">
        <i class="material-icons">{{ info.footerIcon||'date_range' }}</i>
        {{ info.footerText||'From the beginning' }}
      </div>
    </router-link>
  </div> -->
  <div class="card">
    <div class="card-body">
      <p class="card-title text-md-center text-xl-left">{{ info.name }}</p>
      <div
        class="
          d-flex
          flex-wrap
          justify-content-between
          justify-content-md-center
          justify-content-xl-between
          align-items-center
        "
      >
        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
          {{ info.title }}
        </h3>
        <i class="material-icons icon-md text-muted mb-0 mb-md-3 mb-xl-0">{{
          info.icon || "date_range"
        }}</i>
      </div>
      <router-link :to="info.url || {}">
        <p class="mb-0 mt-2 text-warning">
          {{ info.footerText || "From the beginning" }}
        </p>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardSimple",

  data() {
    return {
      info: {
        backgroundColor: "",
        icon: "",
        name: "",
        title: "",
        footerIcon: "",
        footerText: "",
      },
    };
  },

  props: {
    pInfo: {
      type: Object,
      required: true,
    },
  },

  created() {
    this.info = this.pInfo;
  },
};
</script>

<style scoped
       lang="scss">
.cursor-pointer {
  cursor: pointer;
}

.card {
  .card-footer {
    margin: 0;
    padding: 10px 20px;

    &.hover-effect:hover {
      background-color: rgba(#0087cb, 0.1);
    }
  }
}
</style>