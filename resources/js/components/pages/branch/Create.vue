<template>
  <app-card :title="edit ? 'Edit ' + form.title : 'Add New <b>Branch</b>'">
    <!-- <template #actions>
      <app-btn-link route-name="branch.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="this.edit ? this.updateData() : this.saveBranch()">
      
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
              label="Has Locker?"
              v-model="form.locker"
            ></input-checkbox>
            </div>  
            <div class="col-md-3">
                <input-checkbox
                label="Has Atm?"
                v-model="form.atm"
              ></input-checkbox>
              </div>         
            
            <div class="col-md-3">
              <input-checkbox
              label="Is Head Office?"
              v-model="form.headOffice"
            ></input-checkbox>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>District</label>
                  <select class="form-control" v-model="form.district">
                    <option disabled value="">Please select an option</option>
                    <option v-for="option in districts" :value="option.id">{{ option.name }}</option>
                  </select>
                </div>
                <!-- <input-select
                  v-model="form.district"
                  name="district"
                  label="District"
                  :options="districts"
                ></input-select> -->
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>Municipality</label>
                    <select class="form-control" v-model="form.municipality">
                      <option disabled value="">Please select an option</option>
                      <option v-for="option in municipalities" :value="option.id">{{ option.name }}</option>
                    </select>
                  </div>
                <!-- <input-select
                  v-model="form.municipality"
                  name="municipality"
                  label="Municipality"
                  :options="municipalities"
                ></input-select> -->
              </div>
          </div>
          <div class="row">
                <div class="col-md-6">
                  <input-text
                    label="Address Landmarks"
                    name="address"
                    v-model="form.address"
                  ></input-text>
                </div>
                <div class="col-md-6">
                  <p>Lat: {{ this.form.lat }}</p>
                  <p>Long: {{ this.form.long }}</p>
                </div>                
          </div>
          <div class="row justify-content-md-center">
            <div class="col-md-8">
              <div id="myMap" class="z-depth-1-half map-container" style="height: 300px"></div>
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
import District from "@utils/models/District";
import Municipality from "@utils/models/Municipality";
import Branch from "@utils/models/Branch";
import { store, save } from "@utils/mixins/Crud";
import { useRoute } from "vue-router";

export default {
  name: "BranchCreate",

  mixins: [store, save],

  data() {
    return {
      edit: false,
      form: new Form({
        bank:"",
        title: "",
        slug: "",
        phone: "",
        mobile:"",
        display: false,
        locker: false,
        atm: false,
        headOffice: false,
        district:"",
        municipality:"",
        province:"",
        lat:"",
        long:"",
        address: "",
        description:""
      }),
      model: new Branch(),
      district: new District(),
      districts: [],
      municipality: new Municipality(),
      municipalities: [],
      route:"",      
    };
  },

  methods: {

    async saveBranch() {
      this.form.errors.clear();
      try {
        await this.model.store(this.form.data());
        alertMessage("Data saved successfully.");
        this.model.cache.invalidate();
        this.$router.push({
          name: 'branch.list',
            params: { bank: this.form.bank },
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
        this.model.cache.invalidate();
        alertMessage("Data updated successfully.");
        this.$router.push({ name: 'branch.list', params: { bank: this.form.bank }, } );
      } catch (error) {
        console.log(error);
        alertMessage("The given data was invalid.", "danger");
        this.form.errors.initialize(error.data.errors);
      }
    },

    async getData() {
      let data = await this.model.show(this.$route.params.id);
      let { bank, title, slug, phone, mobile, display, locker, atm, headOffice, district, municipality, province, lat, long, address, description } = data.data;

      this.form = new Form({
        bank,
        title,
        slug,
        phone,
        mobile,
        display,
        locker,
        atm,
        headOffice,
        district,
        municipality,
        province,
        lat, long,
        address,
        description
      });
    },

    async getDistricts() {
      let districts = await this.district.getAll();

      this.districts = districts.map((district) => {
        return {
          id: district.id,
          name: district.name,
        };
      });
    },

    async getMunicipality() {
      let municipalities = await this.municipality.getFilterByDistrict(this.form.district);
      
      this.form.province = municipalities.province;
      this.municipalities = municipalities.data.map((municipality) => {
        return {
          id: municipality.id,
          name: municipality.name,
        };
      });
    },
  },

  mounted() {
    this.route = useRoute();
    this.form.bank = this.route.params.bank;
    this.edit = this.$route.params.hasOwnProperty("id");

    this.getDistricts();
    if (this.edit) {
      this.getData();
    }


    const myLatlng = { lat: 27.733697229707158, lng: 85.34125707301315 };
    const map = new google.maps.Map(document.getElementById("myMap"), {
      zoom: 14,
      center: myLatlng,
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "Click the map to get Lat/Lng!",
      position: myLatlng,
    });
    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
      // Close the current InfoWindow.
      infoWindow.close();
      // Create a new InfoWindow.
      infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
      });
      infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
      );
      this.form.lat = mapsMouseEvent.latLng.lat()
      this.form.long = mapsMouseEvent.latLng.lng()
      infoWindow.open(map);
    });
  },

  watch: {
    "form.title": function (val) {
      this.form.slug = Helpers.mySlug(val);
    },

    "form.district": function (val) {
      this.getMunicipality();
    },
    
  },
};
</script>
