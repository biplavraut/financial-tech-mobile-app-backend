<template>
  <div class="row grid-margin">
    <div class="col-lg-12">
      <app-card title="Edit <b>Settings</b>">
        <form @submit.prevent="updateSettings">
          <div class="row">
            <div class="col-md-12">
              <input-image
                v-model="form.logo"
                :image-url="logoUrl"
                id="settings-logo"
                name="Logo"
              ></input-image>
              <small
                class="text-center text-danger"
                v-if="form.errors.has('logo')"
                >{{ form.errors.get("logo") }}
              </small>
            </div>

            <div class="col-md-12">
              <input-text
                label="Company Name"
                name="name"
                v-validate="'required'"
                v-model="form.name"
                :error-text="errors.first('name')"
                required
              ></input-text>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <input-text
                label="Email"
                type="email"
                name="email"
                v-validate="'required|email'"
                :error-text="errors.first('email')"
                v-model="form.email"
                required
              ></input-text>
            </div>
            <div class="col-md-6">
              <input-text
                label="Phone"
                name="phone"
                v-validate="'required'"
                :error-text="errors.first('phone')"
                v-model="form.phone"
                required
              ></input-text>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <input-text
                label="Estd. Date"
                name="establishedDate"
                type="date"
                :error-text="errors.first('establishedDate')"
                v-model="form.establishedDate"
                required
              ></input-text>
            </div>
            <div class="col-md-6">
              <input-text
                label="Address"
                name="address"
                v-validate="'required'"
                :error-text="errors.first('address')"
                v-model="form.address"
                required
              ></input-text>
            </div>
          </div>

          <div class="text-right">
            <button type="submit" class="btn btn-success">Save</button>
          </div>
        </form>
      </app-card>

    </div>
  </div>
</template>

<script>
import { UPDATE_SETTINGS_URL } from "@routes/admin";
import { mapGetters } from "vuex";
import Form from "@utils/Form";

export default {
  name: "Setting",

  data() {
    return {
      form: new Form({
        name: "",
        email: "",
        phone: "",
        establishedDate: "",
        address: "",
        about: "",
        logo: "",
        commission: null,
      }),
      logoUrl: "/images/camera.png",
    };
  },

  methods: {
    updateSettings() {
      this.$validator.validate().then((result) => {
        if (result) {
          this.form
            .put(UPDATE_SETTINGS_URL)
            .then((data) => {
              this.$store.commit("setSettings", data.data);
              this.logoUrl = this.settings.logo;
              this.form.logo = "";
              this.$router.push({ name: `home` });
              alertMessage("Settings successfully saved.");
            })
            .catch((error) => {
              switch (error.status) {
                case 422:
                  this.form.errors.initialize(error.data.errors);
                  if (this.form.errors.has("logo"))
                    Helpers.focusId("settings-logo");
                  break;
                default:
                  alertMessage(error.data.message, "danger");
                  break;
              }
            });
        } else {
          Helpers.focusFirstError(this.errors);
        }
      });
    },
  },

  computed: {
    ...mapGetters(["settings"]),
  },

  mounted() {
    this.form = new Form(this.settings);
    this.form.logo = "";
    this.logoUrl = this.settings.logo;
  },

  watch: {
    "form.logo": function (val) {
      this.form.errors.clear("logo");
    },
  },
};
</script>
