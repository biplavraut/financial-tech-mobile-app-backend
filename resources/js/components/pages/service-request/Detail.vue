<template>
    <app-card :title="'<b>Service Request Detail</b> '">
        <!-- <template #actions>
      <app-btn-link route-name="banner.create">Add New</app-btn-link>
    </template> -->
    <form @submit.prevent="updateStatus">
        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
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
                            <th>Ttile</th>
                            <td>{{ data.title }}</td>
                        </tr>
                        <tr>
                                <th>Type</th>
                                <td>{{ data.type }}</td>
                            </tr>
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
                    </tbody>
                </table>
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>   
    </app-card>
</template>

<script>
import Form from "@utils/Form";
import ServiceRequest from "@utils/models/ServiceRequest";
import moment from "moment";
import { store, save } from "@utils/mixins/Crud";

export default {
    name: "ServiceRequestDetail",

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
            data:{},
            model: new ServiceRequest(),
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
                this.$router.push({ name: `serviceRequest.index` });
            } catch (error) {
                console.log(error);
                alertMessage("The given data was invalid.", "danger");
                this.form.errors.initialize(error.data.errors);
            }
        },

        async getData() {
            let data = await this.model.show(this.$route.params.id);
            this.data = data.data
            this.kyc = data.data.kyc;
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
