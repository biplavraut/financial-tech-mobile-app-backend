<template>
  <!-- <li class="dropdown hidden-xs">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="material-icons">notifications</i>
      <span class="notification" v-if="unreadNotificationsCount > 0">{{
        unreadNotificationsCount
      }}</span>
      <p class="hidden-lg hidden-md">
        Notifications
        <b class="caret"></b>
      </p>
    </a>
    <ul class="dropdown-menu notification-container">
      <li
        v-for="(notification, index) in notifications"
        :key="index"
        v-if="notificationsCount"
        :class="{ unread: model.isUnread(notification) }"
        @click="markAsRead(notification)"
      >
        <img :src="notification.from.image" class="notification-user-image" />
        <span class="nav-notification">
          {{ notification.message }} by <b>{{ notification.from.name }}</b
          ><br />
          <small style="color: #aaaaaa">
            <span class="material-icons" style="font-size: 12px"
              >access_time</span
            >
            <span>{{ notification.createdAt }}</span>
            <span
              class="material-icons pull-right"
              v-if="model.isRead(notification)"
              style="font-size: 12px; margin-right: 10px"
              >done_all</span
            >
          </small>
        </span>
      </li>
      <router-link
        :to="{ name: 'notification.index' }"
        style="text-align: center"
        v-if="!notificationsCount"
        tag="li"
        >You don't have any notification
      </router-link>
      <router-link
        :to="{ name: 'notification.index' }"
        style="text-align: center"
        v-if="notificationsCount"
        tag="li"
        >All Notifications
      </router-link>
    </ul>
  </li> -->
  <div>
    <a
      class="dropdown-item preview-item"
      v-for="(notification, index) in notifications"
      :key="index"
      v-show="notificationsCount"
      :class="{ unread: model.isUnread(notification) }"
      @click="markAsRead(notification)"
    >
      <div class="preview-thumbnail">
        <div
          class="preview-icon bg-success"
          v-if="notification.icon === 'info'"
        >
          <i class="ti-info-alt mx-0"></i>
        </div>
      </div>
      <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal">
          {{ notification.message }}
        </h6>
        <p class="font-weight-light small-text mb-0 text-muted">
          {{ notification.createdAt }}
        </p>
      </div>
    </a>
    <a href="#" class="dropdown-item preview-item" v-if="!notificationsCount">
      You don't have any notification
    </a>
    <router-link
      :to="{ name: 'notification.index' }"
      style="text-align: center"
      v-if="notificationsCount"
      tag="li"
    >
      <a href="#" class="dropdown-item preview-item"> All Notifications </a>
    </router-link>
  </div>
</template>

<script>
import Notification from "@utils/models/Notification";

export default {
  name: "Notification",

  data() {
    return {
      notifications: [],
      model: new Notification(),
    };
  },

  methods: {
    async getNotifications() {
      try {
        let data = await this.model.getPaginatedListUncached();
        this.notifications = data.data.filter((notification, index) => {
          if (index < 5) return notification;
        });
      } catch (e) {
        console.log(e);
      }
    },

    markAsRead(notification) {
      if (this.model.isRead(notification)) {
        if (this.model.getUrl(notification).name !== this.$route.name) {
          this.$router.push(this.model.getUrl(notification));
        }
      } else {
        this.model
          .markAsRead(notification)
          .then((data) => {
            notification.readAt = data;
            if (this.model.getUrl(notification).name !== this.$route.name) {
              this.$router.push(this.model.getUrl(notification));
            }
          })
          .catch((error) => console.log(error));
      }
    },
  },

  computed: {
    notificationsCount() {
      return this.notifications.length;
    },

    unreadNotifications() {
      return this.notifications.filter(this.model.isUnread);
    },

    unreadNotificationsCount() {
      return this.unreadNotifications.length;
    },
  },
  mounted() {
    this.getNotifications();
  },
};
</script>

<style scoped>
.notification-container {
  padding: 0;
}

.notification-container li {
  width: 400px;
  padding: 10px 5px;
  cursor: pointer;
  border-bottom: 1px solid #bbbbbb;
}

.notification-container li:hover {
  background: #eeeeee !important;
}

.nav-notification {
  display: inline-block;
  padding-left: 55px;
}

.nav-notification:hover {
  background: none !important;
  color: #000000 !important;
  box-shadow: none !important;
}

.notification-user-image {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  display: inline-block;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}

.unread {
  background: rgba(0, 0, 255, 0.1);
}
</style>
