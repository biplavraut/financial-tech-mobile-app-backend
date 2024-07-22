<template>
  <app-card :title="edit ? 'Edit ' + form.title : 'Add New <b>Banner</b>'">
    <!-- <template #actions>
      <app-btn-link route-name="banner.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="saveData">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <input-image
            v-model="form.image"
            :image-url="imageUrl"
            name="image"
            id="image"
            label=" Image 5:3 Ratio"
            title="500px * 375px"
            width="150"
            height="150"
          ></input-image>
          <small class="text-danger" v-if="form.errors.has('image')"
            >{{ form.errors.get("image") }}
          </small>
        </div>

        <div class="col-sm-9 col-md-10">
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
                label="Sub Title"
                name="sub_title"
                v-model="form.subTitle"
              ></input-text>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <input-text
                :label="'Page:   '+'  '+form.page"
                name="page"
                v-model="pageValue"
            ></input-text>
            </div>
            <div class="col-md-6">
              <input-text
              :label="'Feature:   '+'  '+form.feature"
              name="feature"
              v-model="featureValue"
            ></input-text>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
            <input-text
              label="Link"
              name="link"
              v-model="form.link"
            ></input-text>
            </div>
            
            <div class="col-md-6">
              <input-checkbox
              label="Display"
              v-model="form.display"
            ></input-checkbox>
            </div>
          </div>
          <button
            type="submit"
            class="btn btn-bibaabo pull-right"
          >
            {{ edit ? "Update" : "Save" }}
          </button>
        </div>
      </div>
    </form>
  </app-card>
</template>

<script>
import Form from "@utils/Form";
import Banner from "@utils/models/Banner";
import { store, save } from "@utils/mixins/Crud";

export default {
  name: "BannerCreate",

  mixins: [store, save],

  data() {
    return {
      edit: false,
      imageUrl: Helpers.cameraImage(),
      form: new Form({
        title: "",
        subTitle: "",
        page:"",
        feature:"",
        image: "",
        link: "",
        display: false,
      }),
      pageValue: "",
      featureValue: "",
      model: new Banner(),
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
        this.model.cache.invalidate();
        alertMessage("Data updated successfully.");
        this.$router.push({ name: `banner.index` });
      } catch (error) {
        console.log(error);
        alertMessage("The given data was invalid.", "danger");
        this.form.errors.initialize(error.data.errors);
      }
    },

    async getData() {
      let data = await this.model.show(this.$route.params.id);
      let { title, subTitle, page, feature, image, link, display } = data.data;

      this.form = new Form({
        title,
        subTitle,
        page,
        feature,
        image: "",
        link,
        display,
      });
      this.pageValue = page;
      this.featureValue = feature
      this.imageUrl = image;
    },
  },

  mounted() {
    this.edit = this.$route.params.hasOwnProperty("id");


    if (this.edit) {
      this.imageUrl = Helpers.loadingImage();
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

    "pageValue": function (val) {
      this.form.page = Helpers.mySlug(val);
    },
    "featureValue": function (val) {
      this.form.feature = Helpers.mySlug(val);
    },
  },
};
</script>
