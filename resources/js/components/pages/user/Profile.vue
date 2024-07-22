<template>
  <div class="row grid-margin">
    <div class="col-lg-12">
      <app-card title="Edit <b>Profile</b>">
        <form @submit.prevent="updateProfile">
          <div class="row">
            <div class="col-md-12">
              <input-image
                v-model="form.image"
                :image-url="authUser.image"
                width="150"
                height="150"
              ></input-image>
              <small
                class="text-center text-danger"
                v-if="form.errors.has('logo')"
                >{{ form.errors.get("logo") }}
              </small>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <input-text
                label="Name"
                name="name"
                v-model="form.name"
                v-validate="'required'"
                required
              ></input-text>
            </div>
            <div class="col-md-6">
              <input-text
                label="Email"
                type="email"
                name="email"
                v-model="form.email"
                v-validate="'required|email'"
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
import Common from "@layouts/Common.vue";
import { UPDATE_PROFILE_URL } from "@routes/admin";
import Form from "@utils/Form";

export default {
  name: "UserProfile",

  extends: Common,

  data() {
    return {
      form: new Form({
        name: "",
        email: "",
        image: "",
        password: "",
        passwordConfirmation: "",
      }),
    };
  },

  methods: {
    updateProfile() {
      this.$validator.validate().then((result) => {
        if (result) {
          this.form
            .post(UPDATE_PROFILE_URL)
            .then((data) => {
              this.password = this.passwordConfirmation = "";
              this.$store.commit("setAuthUser", data.data);
              alertMessage("Your profile is successfully changed.");
            })
            .catch((error) => {
              switch (error.status) {
                case 422:
                  this.form.errors.initialize(error.data.errors);
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

  created() {
    this.form.name = this.authUser.name;
    this.form.email = this.authUser.email;
  },
};
</script>
