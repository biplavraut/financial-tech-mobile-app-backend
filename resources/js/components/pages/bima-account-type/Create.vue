<template>
  <app-card :title="edit ? 'Edit ' + form.title : 'Add New <b>Bima Account Type</b>'">
    <!-- <template #actions>
      <app-btn-link route-name="bima.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="this.edit ? this.updateData() : this.saveBankAccountType()">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <input-image
            v-model="form.image"
            :image-url="imageUrl"
            name="image"
            id="image"
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
                      <label>Main Account Type</label>
                      <select class="form-control" v-model="form.accountType">
                        <option disabled value="">Please select an option</option>
                        <option v-for="option in accountTypes" :value="option.id">{{ option.name }}</option>
                      </select>
                    </div>
              <!-- <input-select
              v-model="form.accountType"
              name="account_type"
              label="Account Type"
              :options="accountTypes"
            ></input-select> -->
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
            <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Bima Account Type Attributes</h4> 
                     <table>
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index ) in form.attribute" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.title }}</td>
                            <td>{{ item.value }}</td>
                            <td><a
                                  @click="deleteAttribute(item.id)"
                                  class="btn btn-sm btn-danger pull-right"
                                >
                                  Delete
                                </a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                              <td><input-text
                                    label="Attribute Title"
                                    name="title"
                                    v-model="aForm.title"
                                  ></input-text></td>
                              <td><input-text
                                      label="Attribute Value"
                                      name="value"
                                      v-model="aForm.value"
                                    ></input-text></td>
                              <td>
                                <a
                                @click="addAttribute()"
                                class="btn btn-bibaabo pull-right"
                              >
                                Add
                              </a>
                              </td>
                          </tr>
                    </tfoot>
                </table>
                  </div>
                </div>
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
import BimaAccountType from "@utils/models/BimaAccountType";
import BimaAccount from "@utils/models/BimaAcoount";
import { store, save } from "@utils/mixins/Crud";
import { useRoute } from 'vue-router';

export default {
  name: "BimaAccountTypeCreate",

  mixins: [store, save],

  data() {
    return {
      edit: false,
      imageUrl: Helpers.cameraImage(),
      form: new Form({
        bima: "",
        title: "",
        slug: "",
        image: "",
        display: false,
        description: "",
        accountType:"",
        attribute: [],
      }),
      aForm: {
        title: "",
        value: "",
      },
      accountTypes: {},      
      pageValue: "",
      featureValue: "",
      model: new BimaAccountType(),
      accountTypeModel: new BimaAccount(),
      route: "",
    };
  },

  methods: {

    addAttribute() {
      if (this.aForm.title != "" && this.aForm.value != "") {
        const data = { 'title': this.aForm.title, 'value': this.aForm.value }
        this.form.attribute.push(data);
        this.aForm.title = ""
        this.aForm.value = ""
      }

    },
    deleteAttribute(id) {
      const confirmDelete = confirm('Are you sure you want to delete this item?');

      if (confirmDelete) {
        axios.get('/admin/delete-attribute/' + id).then((response) => {
          this.getData();
        });
      }

    },
    async saveBankAccountType() {
      this.form.errors.clear();
      try {
        await this.model.store(this.form.data());
        alertMessage("Data saved successfully.");
        this.model.cache.invalidate();
        this.$router.push({
          name: 'bimaAccountType.list',
          params: { bima: this.form.bima },
        });
      } catch (error) {
        this.form.errors.initialize(error.data.errors);
        if (this.form.errors.has("image")) Helpers.focusId("image");
        if (this.form.errors.has("icon")) Helpers.focusId("icon");
      }
    },
    async updateData() {
      try {
        let data = await this.model.update(
          this.$route.params.id,
          this.form.data(true)
        );
        this.imageUrl = data.data.image;
        this.model.cache.invalidate();
        alertMessage("Data updated successfully.");
        this.$router.push({ name: 'bimaAccountType.list', params: { bima: this.form.bima }, });
      } catch (error) {
        console.log(error);
        alertMessage("The given data was invalid.", "danger");
        this.form.errors.initialize(error.data.errors);
      }
    },

    async getData() {
      let data = await this.model.show(this.$route.params.id);
      let { bima, title, slug, image, display, description, accountType, attributes } = data.data;

      this.form = new Form({
        bima,
        title,
        slug,
        image: "",
        display,
        description,
        accountType,
        attribute: attributes,
      });
      this.imageUrl = image;
    },

    async getAccountTypes() {
      let accountTypes = await this.accountTypeModel.getAll('bima');
      //console.log(accountTypes);
      this.accountTypes = accountTypes.data.map((item) => {
        return {
          id: item.id,
          name: item.title,
        };
      });
    },
  },

  mounted() {
    this.route = useRoute();
    this.form.bima = this.route.params.bima;
    this.edit = this.$route.params.hasOwnProperty("id");
    this.getAccountTypes();

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
    "form.title": function (val) {
      this.form.slug = Helpers.mySlug(val);
    }
  },
};
</script>
