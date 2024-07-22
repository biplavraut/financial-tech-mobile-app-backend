<template>
  <div>
    <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
        <img
          src="https://via.placeholder.com/36x36"
          alt="image"
          class="profile-pic"
        />
      </div>
      <div class="preview-item-content flex-grow">
        <h6 class="preview-subject ellipsis font-weight-normal">David Grey</h6>
        <p class="font-weight-light small-text text-muted mb-0">
          The meeting is cancelled
        </p>
      </div>
    </a>
  </div>
</template>

<script>
import Notification from "@utils/models/Notification";

export default {
  name: "Message",

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
      this.$router.push(this.model.getUrl(notification));

      if (this.model.isRead(notification)) return;

      this.model
        .markAsRead(notification)
        .then((data) => {
          notification.readAt = data;
        })
        .catch((error) => console.log(error));
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
    // this.getNotifications();
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
