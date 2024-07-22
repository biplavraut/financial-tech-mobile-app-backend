<template>
  <app-card :title="edit ? 'Edit ' + form.title : 'Add New <b>Service Provider</b>'">
    <!-- <template #actions>
      <app-btn-link route-name="bank.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="saveData">
      <div class="row">
        <div class="col-md-6">
          <input-image
            v-model="form.banner"
            :image-url="imageUrl"
            name="banner"
            id="image"
            label=" Banner 5:3 Ratio"
            title="500px * 375px"
            width="150"
            height="150"
          ></input-image>
          <small class="text-danger" v-if="form.errors.has('banner')"
            >{{ form.errors.get("image") }}
          </small>
        </div>

        <div class="col-md-6">
          <input-image
            v-model="form.logo"
            :image-url="iconUrl"
            name="logo"
            id="icon"
            label=" logo"
            title="500px * 375px"
            width="150"
            height="150"
          ></input-image>
          <small class="text-danger" v-if="form.errors.has('logo')"
            >{{ form.errors.get("icon") }}
          </small>
        </div>
      </div>
          <div class="row">
            <div class="col-md-6">
              <input-text
                label="Title"
                name="title"
                v-validate="'required'"
                v-model="form.title"
                required
              ></input-text>
              <small class="text-danger" v-if="form.errors.has('title')"
                >{{ form.errors.get("title") }}
              </small>
            </div>
            
            <div class="col-md-6">
              <input-text
                label="Slug"
                name="slug"
                v-model="form.slug"
                disabled
              ></input-text>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <input-text
                  label="Phone"
                  name="phone"
                  v-model="form.phone"
                  required
                ></input-text>
                <small class="text-danger" v-if="form.errors.has('phone')"
                  >{{ form.errors.get("phone") }}
                </small>
              </div>
            
              <div class="col-md-6">
                <input-text
                  label="Mobile"
                  name="mobile"
                  v-model="form.mobile"
                ></input-text>
              </div>
            </div>
          <div class="row">
            <div class="col-md-3">
              <input-checkbox
              label="Display"
              v-model="form.display"
            ></input-checkbox>
            </div>          
            
            <div class="col-md-3">
              <input-checkbox
              label="Featured?"
              v-model="form.featured"
            ></input-checkbox>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <input-text
                  label="Rating"
                  name="rating"
                  v-model="form.rating"
                  required
                ></input-text>
              </div>
            
              <div class="col-md-6">
                <div class="form-group asdh-select" name="role">
                      <select class="form-control" v-model="form.type">
                          <option value disabled>Select Type</option>
                          <option
                            data-tokens=""
                            :value="option"
                            v-for="option in serviceTypes"
                            :key="index"
                          >
                            {{ option }}
                          </option>
                        </select>
                  </div>
              </div>
          </div>
          <div class="row">
                <div class="col-md-6">
                  <input-text
                    label="Address"
                    name="address"
                    v-model="form.address"
                    required
                  ></input-text>
                </div>
            </div>
            
          <div class="row">
            <div class="col-md-6">
              <input-text-area
                label="Description"
                name="description"
                :key="0"
                v-model="form.description"
              ></input-text-area>

              <!-- <app-quill-editor label="Description"
              name="description" theme="snow" v-model="form.description"></app-quill-editor> -->
            </div>
            <!-- <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Account Types List</h4> 
                    <div class="list-wrapper pt-2">
                      <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li v-for="(item, index) in form.secondaryAddress">
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              {{ item }}
                            <i class="input-helper"></i>
                            </label>
                          </div> 
                          <i title="Remove Account Type" @click="removeAccType(index)" class="remove ti-close"></i>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </div> -->

            <!-- <div class="col-md-6">
              <label for="">Account Types</label>
              <ul>
                <li v-for="(item, index) in form.secondaryAddress">
                  {{ item }}
                </li>
              </ul>
            </div> -->
            
          </div>
          <button
            type="submit"
            class="btn btn-bibaabo pull-right"
          >
            {{ edit ? "Update" : "Save" }}
          </button>
    </form>
  </app-card>
</template>

<script>
import Form from "@utils/Form";
import ServiceProvider from "@utils/models/ServiceProvider";
import { store, save } from "@utils/mixins/Crud";

export default {
  name: "ServiceProviderCreate",

  mixins: [store, save],

  data() {
    return {
      edit: false,
      imageUrl: Helpers.cameraImage(),
      iconUrl: Helpers.cameraImage(),
      form: new Form({
        title: "",
        slug: "",
        logo:"",
        banner: "",
        phone: "",
        mobile:"",
        display: false,
        featured: false,
        rating:"",
        type:"",
        lat:"",
        long:"",
        address: "",
        secondaryAddress:[],
      }),
      aForm:{
        title:"",
        value:"",
      },
      model: new ServiceProvider(),
      serviceTypes: [
        'Wallet', 'Broker', 'DP', 'SIP'
      ],
    };
  },

  methods: {
    
    async updateData() {
      try {
        let data = await this.model.update(
          this.$route.params.id,
          this.form.data(true)
        );
        this.imageUrl = data.data.image;
        this.iconUrl = data.data.icon;
        this.model.cache.invalidate();
        alertMessage("Data updated successfully.");
        this.$router.push({ name: `service-provider.index` });
      } catch (error) {
        console.log(error);
        alertMessage("The given data was invalid.", "danger");
        this.form.errors.initialize(error.data.errors);
      }
    },

    async getData() {
      let data = await this.model.show(this.$route.params.id);
      let { title, slug, logo, banner, phone, mobile, display, featured, rating, type,lat, long, address, secondaryAddress, description } = data.data;

      this.form = new Form({
        title,
        slug,
        logo: "",
        banner: "",
        phone,
        mobile,
        display,
        featured,
        rating, 
        type,
        lat, long,
        address, secondaryAddress,
        description,
      });
      this.imageUrl = banner;
      this.iconUrl = logo;
    },
  },

  mounted() {
    this.edit = this.$route.params.hasOwnProperty("id");


    if (this.edit) {
      this.imageUrl = Helpers.loadingImage();
      this.iconUrl = Helpers.loadingImage();
      this.getData();
    }
  },

  watch: {
    // "form.image": function (val) {
    //   let type = typeof val;
    //   if (type === "object") {
    //     this.form.errors.clear("image");
    //   }
    // },

    "form.title": function (val) {
      this.form.slug = Helpers.mySlug(val);
    },
    
  },
};
</script>

<style>
.list-wrapper{
  max-height: 250px;
  overflow-x: hidden;
  overflow-y: scroll;
}
</style>
