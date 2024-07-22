    <template>
        <div>
            <app-navbar></app-navbar>
            <div class="container-fluid page-body-wrapper">
                <app-setting-panel></app-setting-panel>

                <app-left-sidebar></app-left-sidebar>

                <div class="main-panel">
                    <div class="content-wrapper">
                    <router-view :key="$route.fullPath" v-slot="{ Component }">
                    <transition name="page-transition">
                        <component :is="Component" />
                    </transition>
                    </router-view>
                    </div>
                    <app-footer></app-footer>
                </div>
            </div>
            <!-- <transition name="page-transition">
                <router-view :key="$route.fullPath"></router-view>
            </transition> -->
        </div>
    </template>
    <script>
    import AppSettingPanel from "./SettingPanel.vue";
    import AppLeftSidebar from "./LeftSideBar.vue";
    import AppNavbar from "./Navbar.vue";
    import AppFooter from "./Footer.vue";
    import { mapGetters, mapMutations } from "vuex";

    export default {
    name: "App",

    components: {
        AppSettingPanel,
        AppLeftSidebar,
        AppNavbar,
        AppFooter,
    },

    props: ["pSettings", "pAuthUser", "pCounts"],

    data() {
        return {};
    },

    methods: {
        ...mapMutations(["setSettings", "setAuthUser", "setHomePageCounts"]),
    },

    computed: {
        ...mapGetters(["settings", "authUser", "csrf"]),
    },

    created() {
        this.setSettings(JSON.parse(this.pSettings));
        this.setAuthUser(JSON.parse(this.pAuthUser));
        this.setHomePageCounts(JSON.parse(this.pCounts));
        console.log(this.$ro)
    },
    };
    </script>

    <style scoped>
    .page-transition-enter-active {
    animation: entering 0.8s;
    opacity: 0;
    }

    @keyframes entering {
    from {
        -webkit-transform: scale(0, 0);
        -moz-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        -o-transform: scale(0, 0);
        transform: scale(0, 0);
    }
    to {
        -webkit-transform: scale(1, 1);
        -moz-transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        -o-transform: scale(1, 1);
        transform: scale(1, 1);
        opacity: 1;
    }
    }
    </style>