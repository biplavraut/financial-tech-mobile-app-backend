<template>
    <app-card :title="'<b>KYC Detail</b> --- Received At: ' + formatDate(kyc.createdAt)">
        <!-- <template #actions>
      <app-btn-link route-name="banner.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="updateStatus">
        <div class="row">
            <div class="col-md-4">
                <input-checkbox disabled
                  label="KYC Verified"
                  v-model="form.kycVerified"
                ></input-checkbox>
            </div>
            <div class="col-md-4">
                <div class="form-group asdh-select" name="role">
                    <select class="form-control" v-model="form.status">
                        <option value disabled>Select Status</option>
                        <option
                          data-tokens=""
                          :value="option"
                          v-for="option in statusOptions"
                          :key="index"
                        >
                          {{ option }}
                        </option>
                      </select>
                </div>
            </div>
            <div class="col-md-4">
                <button
                type="submit"
                class="btn btn-bibaabo pull-right"              >
                Update
              </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive" style="border:1px solid #ccc">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th> Uploaded by</th>
                            <td>
                                <img
                                    :src="kyc.user.avatar"
                                    style="width: 50px; height: 50px; border-radius: 50%"
                                    />
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ kyc.user.name }}
                                <label class="badge badge-success" v-if="kyc.user.verified"
                                        >Verified</label
                                    >
                                    <label class="badge badge-danger" v-else
                                        >Not Verified</label
                                    >
                            </td>                
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ kyc.user.email }}</td>                
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ kyc.user.phone }} <i title="Verified?"
                                :class="kyc.user.phoneVerified ? 'ti-check' : 'ti-close'"
                                ></i></td>                
                        </tr>
                        <tr>
                            <th>KYC Created for</th>
                            <td><i
                                :class="kyc.self ? 'badge-success' : 'badge-warning'"
                            > {{ kyc.self ? "self" : "other" }}</i></td>                
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <app-card :title="'<b>PP Photo</b>'">
                        <a :href="kyc.ppPhoto" title="View Image" target="_blank">
                            <img
                                :src="kyc.ppPhoto"
                                style="width: 100%; height: 100%; border-radius: 0"
                                />
                        </a>
                    </app-card>
                    
                </div>
                <div class="col-md-6">
                    <app-card :title="'<b>Signature</b>'">
                        <a :href="kyc.map" title="View Image" target="_blank">
                            <img
                                :src="kyc.map"
                                style="width: 100%; height: 100%; border-radius: 0"
                                />
                        </a>
                    </app-card>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive" style="border:1px solid #ccc">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th> KYC CODE</th>
                            <td>
                                {{ kyc.kycCode }}
                                <label class="badge badge-success" v-if="kyc.kycVerified"
                                            >Verified</label
                                        >
                                        <label class="badge badge-danger" v-else
                                            >Not Verified</label
                                        >
                            </td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>{{ kyc.salutation + ' ' + kyc.firstName + ' ' + kyc.middleName + ' ' + kyc.lastName }}
                            </td>                
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ kyc.gender }}</td>                
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{ kyc.nationality }} </td>                
                        </tr>
                        <tr>
                            <th>Maritial Status</th>
                            <td>{{ kyc.maritalStatus }} </td>                
                        </tr>
                        <tr>
                            <th>DOB</th>
                            <td>{{ kyc.dobBs +' BS / ' + kyc.dobAd +' AD' }} </td>                
                        </tr>
                        <tr>
                            <th>Contact / Email</th>
                            <td>{{ kyc.countryCode + ' , ' + kyc.phone + ' , ' + kyc.mobile + ' , ' + kyc.email }} </td>                
                        </tr>

                        <!-- <tr>
                            <th>PEPS Member</th>
                            <td>{{ kyc.pepsDetail }} <label class="badge badge-success" v-if="kyc.pepsMember"
                                                >Member</label
                                            >
                                            <label class="badge badge-danger" v-else
                                                >Not Member</label
                                            > </td>                
                        </tr>
                        <tr>
                            <th>Beneficial</th>
                            <td>{{ kyc.beneficial }} <br/> 
                                {{ 'Name: '+ kyc.beneficialName }} <br/> 
                                {{ 'Citizenship No.: ' + kyc.beneficialCtznNo }} <br/>
                                {{ 'Relation: ' + kyc.beneficialRelation }} <br/>
                                {{ 'Address: '  + kyc.beneficialAddress }} <br/>
                                {{ 'Contact: ' + kyc.beneficialContact }}
                            </td>                
                        </tr> -->
                        <tr>
                            <th>Remarks</th>
                            <td>{{ kyc.decleration }} </td>                
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
    <app-card :title="'<b>Address</b>'">
        <app-table-sortable
          :columns="addressColumns"
          :rows="addressRows"
          :actions="false"
        >
          <template #rowData="{ row }">
            <td width="100">
                {{ row.type }}
              </td>
            <td>{{ row.provinceNo + ' ' + row.provinceName }} </td>
            <td>{{ row.zone }}</td>
            <td>
              {{ row.district }}
            </td>
            <td>
                {{ row.vdcMunicipality }}
            </td>
            <td>
                {{ row.ward }}
            </td>
            <td>
                {{ row.streetTole }}
            </td>
            <td>
                {{ row.houseNo }}
            </td>
            <td>
                {{ row.tel + ', ' + row.mobile + ', ' + row.email}}
            </td>
          </template>
        </app-table-sortable>
    </app-card>

    <!-- Documents -->
    <app-card :title="'<b>Documents</b>'">
            <app-table-sortable
              :columns="documentColumns"
              :rows="documentRows"
              :actions="false"
            >
              <template #rowData="{ row }">
                <td width="100">
                    {{ row.type }}
                  </td>
                <td>{{ row.number }} </td>
                <td>{{ row.officeOfIssuance }}</td>
                <td>
                  {{ row.dateOfIssue }}
                </td>
                <td>
                    {{ row.issueDistrict }}
                </td>
                <td>
                    {{ row.validTill }}
                </td>
                <td>
                    <a :href="row.front" title="View Image" target="_blank">
                        <img
                            :src="row.front"
                            style="width: 50px; height: 50px; border-radius: 0"
                            />
                    </a>
                </td>
                <td>
                    <a :href="row.back" title="View Image" target="_blank">
                        <img
                            :src="row.back"
                            style="width: 50px; height: 50px; border-radius: 0"
                            />
                    </a>
                </td>
                <td>
                    <a :href="row.selfiee" title="View Image" target="_blank">
                        <img
                            :src="row.selfiee"
                            style="width: 50px; height: 50px;  border-radius: 0"
                            />
                    </a>
                </td>
              </template>
            </app-table-sortable>
        </app-card>
        <app-card :title="'<b>Occupation</b>'">
            <app-table-sortable
              :columns="occupationColumns"
              :rows="occupationRows"
              :actions="false"
            >
              <template #rowData="{ row }">
                <td width="100">
                    {{ row.type }}
                  </td>
                <td>{{ row.office }} </td>
                <td>{{ row.address }}</td>
                <td>
                  {{ row.position }}
                </td>
                <td>
                    {{ row.estAnnualIncome }}
                </td>
                <td>
                    {{ row.estAnnualTurnover }}
                </td>
                <td>
                    {{ row.tel }}
                </td>
              </template>
            </app-table-sortable>
        </app-card>

        <app-card :title="'<b>Family</b>'">
                <app-table-sortable
                  :columns="familyColumns"
                  :rows="familyRows"
                  :actions="false"
                >
                  <template #rowData="{ row }">
                    <td width="100">
                        {{ row.relation }}
                      </td>
                    <td>{{ row.fullName }} </td>
                    <td>{{ row.citizenshipNo }}</td>
                    <td>
                      {{ row.placeOfIssue }}
                    </td>
                    <td>
                        {{ row.dateOfIssue }}
                    </td>
                    <td>
                        {{ row.contact }}
                    </td>
                  </template>
                </app-table-sortable>
            </app-card>
    </app-card>
</template>

<script>
import Form from "@utils/Form";
import Kyc from "@utils/models/Kyc";
import moment from "moment";
import { store, save } from "@utils/mixins/Crud";

export default {
    name: "KycDetail",

    mixins: [store, save],

    data() {
        return {
            edit: false,
            imageUrl: Helpers.cameraImage(),
            form: new Form({
                status: "",
                kycVerified: ""
            }),
            statusOptions:[
                'received', 'processing', 'invalid', 'valid', 'rejected', 'archive', 'verified'
            ],
            pageValue: "",
            featureValue: "",
            kyc:{
                user: [],
                document: [],
                occupation:	[],
                family: [],                           
            },

            addressColumns: [
                "Type",
                "Province",
                "Zone",
                "District",
                "VDC/Municipality",
                "Ward",
                "Street/Tole",
                "House No",
                "Contact"
            ],
            addressRows: { data: [], links: {}, meta: {} },

            documentColumns: [
                "Type",
                "number",
                "Office Of Issuance",
                "Date of Issuance",
                "Issue District",                
                "Valid Till",
                "Front",
                "Back",
                "Selfiee"
            ],
            documentRows: { data: [], links: {}, meta: {} },

            occupationColumns: [
                "Type",
                "Office",
                "Address",
                "Position",
                "Est. Annual Income",
                "Est. Annual Turnover",
                "Contact"
            ],
            occupationRows: { data: [], links: {}, meta: {} },

            familyColumns: [
                "Relation",
                "Full Name",
                "Citizenship No.",
                "Place of Issue",
                "Date of Issue",
                "Contact"
            ],
            familyRows: { data: [], links: {}, meta: {} },
            model: new Kyc(),
        };
    },

    methods: {
        formatDate(date) {
            return moment(date).format("LLLL");
        },
        async updateStatus() {
            try {
                let data = await this.model.update(
                    this.$route.params.id,
                    this.form.data(true)
                );
                this.model.cache.invalidate();
                alertMessage("Data updated successfully.");
                this.$router.push({ name: `kyc.index` });
            } catch (error) {
                console.log(error);
                alertMessage("The given data was invalid.", "danger");
                this.form.errors.initialize(error.data.errors);
            }
        },

        async getData() {
            let data = await this.model.show(this.$route.params.id);
            this.kyc = data.data;
            this.addressRows.data = data.data.address;
            this.documentRows.data = data.data.document;
            this.occupationRows.data = data.data.occupation;
            this.familyRows.data = data.data.family;
            let { status, kycVerified } = data.data;

            this.form = new Form({
                status,
                kycVerified
            });
        },
    },
    created() {
        this.edit = this.$route.params.hasOwnProperty("id");


        if (this.edit) {
            this.imageUrl = Helpers.loadingImage();
            this.getData();
        }
    },

    mounted() {
        // this.edit = this.$route.params.hasOwnProperty("id");


        // if (this.edit) {
        //     this.imageUrl = Helpers.loadingImage();
        //     this.getData();
        // }
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
