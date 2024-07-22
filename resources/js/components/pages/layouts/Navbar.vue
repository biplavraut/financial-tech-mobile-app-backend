<template>
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div
      class="
        text-center
        navbar-brand-wrapper
        d-flex
        align-items-center
        justify-content-center
      "
    >
      <a class="navbar-brand brand-logo mr-5" :href="homeURL"
        ><img :src="settings.logoBig" class="mr-2" :alt="settings.name"
      /></a>
      <a class="navbar-brand brand-logo-mini" href="/"
        ><img :src="settings.logoMini" :alt="settings.name"
      /></a>
    </div>
    <div
      class="navbar-menu-wrapper d-flex align-items-center justify-content-end"
    >
      <button
        class="navbar-toggler navbar-toggler align-self-center"
        type="button"
        data-toggle="minimize"
      >
        <span class="ti-layout-grid2"></span>
      </button>
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-search d-none d-lg-block">
          <div class="input-group">
            <div
              class="input-group-prepend hover-cursor"
              id="navbar-search-icon"
            >
              <span class="input-group-text" id="search">
                <i class="ti-search"></i>
              </span>
            </div>
            <input
              type="text"
              class="form-control"
              id="navbar-search-input"
              placeholder="Search now"
              aria-label="search"
              aria-describedby="search"
            />
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-nav-right">
        <!-- <li class="nav-item dropdown mr-1">
          <a
            class="
              nav-link
              count-indicator
              dropdown-toggle
              d-flex
              justify-content-center
              align-items-center
            "
            id="messageDropdown"
            href="#"
            data-toggle="dropdown"
          >
            <i class="ti-email mx-0"></i>
          </a>
          <div
            class="
              dropdown-menu dropdown-menu-right
              navbar-dropdown
              preview-list
            "
            aria-labelledby="messageDropdown"
          >
            <p class="mb-0 font-weight-normal float-left dropdown-header">
              Messages
            </p>
            <message></message>
          </div>
        </li> -->
        <!-- <li class="nav-item dropdown">
          <a
            class="nav-link count-indicator dropdown-toggle"
            id="notificationDropdown"
            href="#"
            data-toggle="dropdown"
          >
            <i class="ti-bell mx-0"></i>
            <span class="count"></span>
          </a>
          <div
            class="
              dropdown-menu dropdown-menu-right
              navbar-dropdown
              preview-list
            "
            aria-labelledby="notificationDropdown"
          >
            <p class="mb-0 font-weight-normal float-left dropdown-header">
              Notifications
            </p>
            <notification></notification>
          </div>
        </li> -->
        <!-- <li class="nav-item nav-profile dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            data-toggle="dropdown"
            id="profileDropdown"
          >
            <img :src="authUser.image" :alt="authUser.name" />
          </a>
          <div
            class="dropdown-menu dropdown-menu-right navbar-dropdown"
            aria-labelledby="profileDropdown"
          >
            <router-link class="dropdown-item" :to="{ name: 'user.profile' }">
              <i class="ti-user text-primary"></i>
              My Profile</router-link
            >
            <router-link class="dropdown-item" :to="{ name: 'settings' }">
              <i class="ti-settings text-primary"></i>
              Settings</router-link
            >
            <router-link
              class="dropdown-item"
              :to="{ name: 'user.changePassword' }"
            >
              <i class="ti-layers text-primary"></i>
              Change Password</router-link
            >
            <a
              class="dropdown-item"
              :href="logoutUrl"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
              <i class="ti-power-off text-primary"></i>
              Logout
            </a>
          </div>
        </li> -->
        <!-- =============================== -->
        
        <!-- <li class="nav-item d-none d-lg-flex">
          <router-link class="nav-link" :to="{ name: 'user.profile' }" title="Profile">
            <i class="ti-user text-primary"></i>
          </router-link>
        </li>
        <li class="nav-item d-none d-lg-flex">
          <router-link class="nav-link" :to="{ name: 'settings' }">
              <i class="ti-settings text-primary"></i>
              </router-link>
        </li> -->

        <!-- ==================================== -->
        <!-- <li class="nav-item d-none d-lg-flex">
          <router-link
              class="nav-link"
              :to="{ name: 'user.changePassword' }"
              title="Change Password"
            >
              <i class="ti-layers text-primary"></i>
              </router-link
            >
        </li> -->
        <li class="nav-item d-none d-lg-flex">
          <a class="nav-link" :href="logoutUrl" title="Logout"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ti-power-off text-primary"></i>
          </a>
        </li>
        
            <form
              id="logout-form"
              :action="logoutUrl"
              method="POST"
              style="display: none"
            >
              <input type="hidden" name="_token" :value="csrf" />
            </form>

        <!-- <li class="nav-item nav-settings d-none d-lg-flex">
          <a class="nav-link" href="#">
            <i class="ti-more"></i>
          </a>
        </li> -->
      </ul>
      <button
        class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
        type="button"
        data-toggle="offcanvas"
      >
        <span class="ti-layout-grid2"></span>
      </button>
    </div>
  </nav>
</template>

<script>
import Common from "./Common.vue";
import { ROOT_URL, LOGOUT_URL } from "@routes/admin";
import { mapGetters } from "vuex";

// import Notification from "./Notification.vue";
// import Message from "./Message.vue";

export default {
  name: "Navbar",

  extends: Common,

  // components: {
  //   Notification,
  //   Message,
  // },

  computed: {
    ...mapGetters(["settings", "authUser"]),

    homeURL() {
      return ROOT_URL + "admin";
    },
    logoutUrl() {
      return LOGOUT_URL;
    },
  },
};
</script>
