<template>
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <div v-for="(leftNavItem, key) in leftNavItems"
        :key="key"
      >
        <div v-if="leftNavItem.children.length === 0">
          <li class="nav-item"
            :class="{ active: $route.name === leftNavItem.url.name }" >
            <router-link
              class="nav-link"
              :to="leftNavItem.url">
              <i :class="leftNavItem.icon + ' menu-icon'"></i>
              <span class="menu-title">{{ leftNavItem.name }} </span>
            </router-link>          
          </li>
        </div>        
        <div v-else class="mtb-5">
          <i :class="leftNavItem.icon + ' menu-icon'"></i>
          <b class="menu-title ml-5">{{ leftNavItem.name }} </b>
          <hr/>

          <li class="nav-item"
            :class="{ active: $route.name === leftNavItemChild.url.name }"
            v-for="(leftNavItemChild, index) in leftNavItem.children"
            :key="index">
            <router-link
              :to="leftNavItemChild.url"
              class="nav-link"
            >
            <i :class="leftNavItemChild.icon + ' menu-icon'"></i>
              <span class="menu-title">{{ leftNavItemChild.name }} </span>
            </router-link>
          </li>
          <hr/>
        </div>
      </div>
        
    </ul>

    
  </nav>
</template>

<script>
import Common from "./Common.vue";
import { ROOT_URL, LOGOUT_URL } from "@routes/admin";

export default {
  name: "LeftSideBar",

  extends: Common,

  data() {
    return {
      userNavItems: [
        { url: { name: "user.profile" }, name: "My Profile" },
        { url: { name: "user.changePassword" }, name: "Change Password" },
      ],

      leftNavItems: [
        {
          name: "Dashboard",
          icon: "ti-home",
          url: { name: "home" },
          children: [],
        },
        
        {
          name: "Banner",
          icon: "ti-image",
          url: { name: "banner.index" },
          children: [],
        },
        {
          name: "eBank Management",
          icon: "",
          url: {},
          children: [
            {
              name: "eBank Services",
              icon: "ti-package",
              url: { name: "service.index" },
              children: [],
            },
            {
              name: "eBank Account Types",
              icon: "ti-view-list",
              url: { name: "account.index" },
              children: [],
            },
            {
              name: "eLoan",
              icon: "ti-panel",
              url: { name: "loan.index" },
              children: [],
            },
            {
              name: "Bank",
              icon: "ti-money",
              url: { name: "bank.index" },
              children: [],
            },              
          ],
        },
        {
          name: "eBima Management",
          icon: "",
          url: {},
          children: [
            {
              name: "eBima Accounts",
              icon: "ti-harddrive",
              url: { name: "bima-account.index" },
              children: [],
            },
            {
              name: "Bima",
              icon: "ti-pulse",
              url: { name: "bima.index" },
              children: [],
            },
          ],
        },
        {
          name: "KYC Management",
          icon: "",
          url: {},
          children: [
            {
              name: "KYC",
              icon: "ti-id-badge",
              url: { name: "kyc.index" },
              children: [],
            }
          ],
        },
        {
          name: "Service Providers",
          icon: "ti-crown",
          url: { name: "service-provider.index" },
          children: [],
        },
        {
          name: "Service Request",
          icon: "ti-layers-alt",
          url: { name: "serviceRequest.index" },
          children: [],
        },
        {
          name: "App User",
          icon: "ti-user",
          url: { name: "user.index" },
          children: [],
        },
        
      ],
    };
  },

  methods: {
    
  },

  computed: {
    userNavNames() {
      return this.userNavItems.map((item) => item.url.name);
    },

    isUserNav() {
      // check if array contains the value
      //return this.userNavNames.indexOf(this.$route.name) > -1;
    },

    backgroundImage() {
      return ROOT_URL + "dashboard/img/sidebar-1.jpg";
    },

    logoutUrl() {
      return LOGOUT_URL;
    },
  },
};
</script>
<style>
hr{
  margin: 0px !important;
  border-top: 1px solid rgba(218, 210, 210, 0.1);
}
.mtb-5{
  margin: 5% 0px;
}
  
</style>
