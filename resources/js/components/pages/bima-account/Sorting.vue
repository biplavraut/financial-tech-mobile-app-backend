<template>
    <div class="row grid-margin">
        <div class="col-lg-12">
            <app-card title="All <b>Accounts</b>" body-padding="0">
                <template slot="actions">
                    <app-btn-link route-name="account.create">Add New</app-btn-link>
                </template>
                <vue-nestable v-model="accounts" :max-depth="4" v-on:change="listChange(accounts)">
                    <template slot-scope="{ item }">
                        <!-- Handler -->
                        <vue-nestable-handle :item="item" class="mt-2">
                            <b-row align-v="center">
                                <b-col>
                                    <i class="ti-view-list menu-icon"></i> <span>{{ item.title }}</span>
                                </b-col>
                            </b-row>
                        </vue-nestable-handle>
                    </template>
                </vue-nestable>
            </app-card>
        </div>
    </div>
</template>

<script>
import Account from "@utils/models/Acoount"; 
import moment from "moment";
import { index, destroy } from "@utils/mixins/Crud";
import { mapGetters } from "vuex";
export default {
    name: "AccountList",

    mixins: [index, destroy],
    data() {
        return {
            accounts: [],
            model: new Account(),
        }
    },

    methods: {
        getData() {
            axios.get('/admin/listAccount')
                .then(({ data }) => {
                    this.accounts = data.data
                }).catch(() => {
                    alertMessage("Something Went Wrong.", "danger");
                })
        },

        listChange(accounts) {
            // console.log(newElectronics);
            axios({
                method: 'post',
                url: '/admin/orderAccount',
                data: {
                    accounts
                },
            }).then((response) => {
                if (response.status) {
                    alertMessage("Data updated successfully.");
                } else {
                    alertMessage(response.message, 'danger');
                }
            }).catch((error) => {
                alertMessage('Something Went Wrong!', 'warning')
            })

        },

    },
    created() {
        this.getData();
    },
    mounted() { },
    computed: {
        ...mapGetters(["authUser"]),
    },
    watch: {},
}
</script>
