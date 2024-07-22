<template>
  <app-card :title="edit ? 'Edit ' + form.title : 'Add New <b>Bima Account Types</b>'">
    <!-- <template #actions>
      <app-btn-link route-name="service.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="saveData">
      <div class="row">
        <div class="col-md-6">
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

        <div class="col-md-6">
          <input-image
            v-model="form.icon"
            :image-url="iconUrl"
            name="icon"
            id="icon"
            label=" Icon"
            title="500px * 375px"
            width="150"
            height="150"
          ></input-image>
          <small class="text-danger" v-if="form.errors.has('icon')"
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
              <input-checkbox
              label="Display"
              v-model="form.display"
            ></input-checkbox>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Type</label>
                <select class="form-control" v-model="form.type">
                  <option disabled value="">Please select an option</option>
                  <option v-for="option in selectTypes" :value="option.id">{{ option.name }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <input-text-area
                label="Description"
                name="description"
                :key="0"
                v-model="form.description"
              ></input-text-area>

            <!-- <app-quill-editor label="Description"
              name="description" theme="snow" v-model="form.description"></app-quill-editor> -->
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
import BimaAccount from "../../../utils/models/BimaAcoount";
import { store, save } from "@utils/mixins/Crud";

export default {
  name: "BimaAccountCreate",

  mixins: [store, save],

  data() {
    return {
      edit: false,
      imageUrl: Helpers.cameraImage(),
      iconUrl: Helpers.cameraImage(),
      form: new Form({
        title: "",
        slug: "",
        type:"",
        icon:"",
        image: "",
        display: false,
        description: ""
      }),
      model: new BimaAccount(),
      selectTypes: [
        { name: 'Life Insurance', id: 'life' },
        { name: 'Non Life Insurance', id: 'non-life' }
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
        this.$router.push({ name: `bima-account.index` });
      } catch (error) {
        console.log(error);
        alertMessage("The given data was invalid.", "danger");
        this.form.errors.initialize(error.data.errors);
      }
    },

    async getData() {
      let data = await this.model.show(this.$route.params.id);
      let { title, slug, type, icon, image, display, description } = data.data;

      this.form = new Form({
        title,
        slug,
        type,
        icon: "",
        image: "",
        display,
        description
      });
      this.imageUrl = image;
      this.iconUrl = icon;
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
