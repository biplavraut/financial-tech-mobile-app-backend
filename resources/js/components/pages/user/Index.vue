<template>
  <div class="row grid-margin">
    <div class="col-lg-12">
      <app-card title="App <b>Users</b>" body-padding="0">
        <app-table-sortable :columns="columns" :rows="rows" :paginate="true">
          <template #rowData="{ row }">
            <td width="100">
              <img
                :src="row.avatar"
                style="width: 50px; height: 50px; border-radius: none"
              />
            </td>
            <td>{{ row.name }}</td>
            <td>{{ row.email }}</td>
            <td>
              {{ row.phone }}
              <div
                class="badge badge-pill"
                :class="row.phoneVerified ? 'badge-success' : 'badge-danger'"
                :title="
                  row.phoneVerified ? 'Phone Verified' : 'Phone UnVerified'
                "
              >
                <i
                  :class="row.phoneVerified ? 'ti-check' : 'ti-close'"
                ></i>
              </div>
            </td>
            <td>{{ row.createdAt }}</td>
            <td>{{ row.lastLoginAt }}</td>
            <td>
              <label class="badge badge-danger" v-if="row.blocked"
                  >Blocked</label
                >
                <label class="badge badge-success" v-else
                  >Not Blocked</label
                >
            </td>
            <td width="100">
              <a
                @click="changeBlocked(row.blocked, row.id)"
                class="btn btn-primary pull-right"
              >
                {{ row.blocked ? 'Unblock User' : 'Block USer'}}
              </a>
              
              <!-- <app-actions
                @deleteItem="deleteModel"
                :actions="{
                  delete: row.id,
                }"
              >
              </app-actions> -->
            </td>
          </template>
        </app-table-sortable>
      </app-card>
    </div>
  </div>
</template>

<script>
import User from "@utils/models/User";
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { mapGetters } from "vuex";
import CryptoJS from "crypto-js";

const key = "base64:BjSA0Jrmm27XL3T1I4/aKp4kxUdIomeT/lK4Zxo5eFo=";

export default {
  name: "UserIndex",

  mixins: [index, destroy],

  data() {
    return {
      rows: { data: [], links: {}, meta: {} },
      columns: [
        "Image",
        "Name",
        "E-mail",
        "Phone",
        "Created at",
        "Last Login at",
        "Status",
      ],
      model: new User(),
    };
  },

  methods: {
    changeBlocked(blocked, userid){
      if(blocked == 1){
        blocked = 0;
      }else{
        blocked = 1;
      }
      if (
        confirm("Are you sure? You want to Block this User?")
      ) {
        axios
          .post("/admin/user/blocked", {
            id: userid,
            blocked: blocked
          })
          .then((response) => {
            if (response.status == 200) {
              alertMessage("User Updated");
              this.reset()
            } else {
              alertMessage("Something went wrong while processing", "danger");
            }
          })
          .catch(function (error) {
            alertMessage("Something went wrong while processing", "danger");
          });
      }
    },
    changeUserPassword(userid) {
      if (
        confirm("Are you sure? You want to reset the password for this user.?")
      ) {
        axios
          .post("/admin/user/changepassword", {
            id: userid,
          })
          .then((response) => {
            if (response.status == 200) {
              alertMessage("New password successfully sent to user though SMS");
            } else {
              alertMessage("Something went wrong while processing", "danger");
            }
          })
          .catch(function (error) {
            alertMessage("Something went wrong while processing", "danger");
          });
      }
    },
    formatDate(date) {
      return moment(date).format("LLLL");
    },
    copy(no) {
      var dummy = document.createElement("textarea");
      document.body.appendChild(dummy);
      dummy.value = no;
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
      alertMessage("Content copied to clipboard.");
    },
    reset() {
      this.state = "all";
      axios.get(this.model.indexUrl).then((response) => {
        this.rows.data = response.data.data;
        this.rows.links = response.data.links;
        this.rows.meta = response.data.meta;
        this.counter.all = response.data.meta.total;
      });
    },
    blockedList() {
      this.state = "block";
      axios.get(this.model.indexUrl + "/state?block=1").then((response) => {
        this.rows.data = response.data.data;
        this.rows.links = response.data.links;
        this.rows.meta = response.data.meta;
        this.counter.blocked = response.data.meta.total;
      });
    },
    activeList() {
      this.state = "active";
      axios.get(this.model.indexUrl + "/state?active=1").then((response) => {
        this.rows.data = response.data.data;
        this.rows.links = response.data.links;
        this.rows.meta = response.data.meta;
        this.counter.active = response.data.meta.total;
      });
    },
    passiveList() {
      this.state = "passive";
      axios.get(this.model.indexUrl + "/state?passive=1").then((response) => {
        this.rows.data = response.data.data;
        this.rows.links = response.data.links;
        this.rows.meta = response.data.meta;
        this.counter.passive = response.data.meta.total;
      });
    },
    blockUser(user) {
      if (confirm("Are you sure? You want to execute this.")) {
        axios
          .get(
            this.model.indexUrl +
              "/block?id=" +
              user.id +
              "&state=" +
              user.blocked
          )
          .then((response) => {
            alertMessage(response.data);
            var state = user.blocked;
            user.blocked = state ? false : true;
          });
      }
    },
    aesEncrypt(txt) {
      const cipher = CryptoJS.AES.encrypt(
        txt,
        CryptoJS.enc.Base64.parse(key).toString()
      );

      return cipher.toString(CryptoJS.enc.Hex);
    },
    aesDencrypt(txt) {
      // const cipher = CryptoJS.decrypt(txt, key);
      // return cipher.toString();
      return txt.toString(CryptoJS.enc.Utf8);
    },
  },
  created() {
    this.getModels();
  },
  mounted() {
    console
      .log
      // this.aesEncrypt("12")
      // this.aesDencrypt(
      //   "6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918"
      // )
      ();
  },
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
