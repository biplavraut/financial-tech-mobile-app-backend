<template>
  <footer class="footer">
    <div class="container-fluid clearfix">
      <span
        class="text-muted d-block text-center text-sm-left d-sm-inline-block"
        >Copyright &copy; {{ year }}
        <router-link :to="{ name: 'home' }">{{ settings.name }}</router-link>
        . All rights reserved.</span
      >
      <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"
        > &#60;&#8725;&#62;<i class="mdi mdi-heart text-danger"></i>
      </span>
    </div>
  </footer>
  <!-- <footer class="footer">
    <div class="container-fluid">
      <p class="copyright pull-right">
        &copy;
        <router-link :to="{name: 'home'}">{{ settings.name }}</router-link>,
        <span>{{ year }}</span>
      </p>
    </div>
  </footer> -->
</template>

<script>
import Common from "./Common.vue";

export default {
  name: "Footer",

  extends: Common,

  data() {
    return {
      year: new Date().getFullYear(),
    };
  },
};
</script>
