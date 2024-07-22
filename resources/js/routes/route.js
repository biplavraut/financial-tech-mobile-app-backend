import { createRouter, createWebHistory } from 'vue-router';
import { startCase } from 'lodash';

import Parent from "../components/pages/Parent.vue";

// let pluralise = require("pluralise");

function resourceUrl(resource, plural) {
    return [{
            path: "all",
            name: resource + ".index",
            component: () =>
                import (
                    `../components/pages/${resource}/Index.vue`
                ),
            meta: {
                title: "All " + startCase(plural),
            },
        },
        {
            path: "create",
            name: resource + ".create",
            component: () =>
                import (
                    `../components/pages/${resource}/Create.vue`
                ),
            meta: {
                title: `Add a New ${resource}`,
            },
        },
        {
            path: ":id/edit",
            name: resource + ".edit",
            component: () => import(
                `../components/pages/${resource}/Create.vue`
                ),
            meta: {
                title: `Edit ${resource}`,
            },
        },
    ];
}

let routes = [{
    path: "/admin/v1",
    component: Parent,
    children: [{
            path: "",
            name: "home",
            // component: require("@pages/Index").default,
            component: () => import("@pages/Index.vue"),
            meta: {
                title: "Home",
            },
        },
        {
            path: "user",
            component: Parent,
            children: [{
                path: "my-profile",
                name: "user.profile",
                component: () =>
                    import("@pages/user/Profile.vue"),
                meta: {
                    title: "My Profile",
                },
            },
            {
                path: "change-password",
                name: "user.changePassword",
                component: () =>
                    import("@pages/user/ChangePassword.vue"),
                meta: {
                    title: "Change Password",
                },
            },
            ],
        },
        {
            path: "settings",
            name: "settings",
            component: () =>
                import("@pages/Setting.vue"),
            meta: {
                title: "Settings",
            },
        },
        // {
        //     path: "notifications",
        //     name: "notification.index",
        //     component: () =>
        //         import("@pages/notification/Index.vue"),
        //     meta: {
        //         title: "All Notifications",
        //     },
        // },

        {
            path: "users",
            name: "user.index",
            component: () =>
                import("@pages/user/Index.vue"),
            meta: {
                title: "All App Users",
            },
        },

        {
            path: "banner",
            component: Parent,
            children: resourceUrl("banner", "banners"),
        },
        {
            path: "service",
            component: Parent,
            children: resourceUrl("service", "services"),
        },

        {
            path: "account",
            component: Parent,
            children: resourceUrl("account", "accounts"),
        },
        {
            path: "account/list",
            name: "account.list",
            component: () =>
                import("@pages/account/Sorting.vue"),
            meta: {
                title: "List Acounts",
            },
        },

        {
            path: "bank",
            component: Parent,
            children: resourceUrl("bank", "banks"),
        },
        {
            path: "bank/branch/:bank",
            name: "branch.list",
            component: () =>
                import("@pages/branch/Index.vue"),
            meta: {
                title: "List Branches",
            },
        },
        {
            path: "bank/branch/:bank/create",
            name: "branch.create",
            component: () =>
                import("@pages/branch/Create.vue"),
            meta: {
                title: "Create Branches",
            },
        },
        {
            path: "branch/:id/edit",
            name: "branch.edit",
            component: () =>
                import("@pages/branch/Create.vue"),
            meta: {
                title: "Edit Branches",
            },
        },

        {
            path: "bank/bank-account-type/:bank",
            name: "bankAccountType.list",
            component: () =>
                import("@pages/bank-account-type/Index.vue"),
            meta: {
                title: "List Bank Account Types",
            },
        },
        {
            path: "bank/bank-account-type/:bank/create",
            name: "bankAccountType.create",
            component: () =>
                import("@pages/bank-account-type/Create.vue"),
            meta: {
                title: "Create Bank Account Types",
            },
        },
        {
            path: "bank-account-type/:id/edit",
            name: "bankAccountType.edit",
            component: () =>
                import("@pages/bank-account-type/Create.vue"),
            meta: {
                title: "Edit Bank Account Types",
            },
        },
        {
            path: "bank/bank-service-type/:bank",
            name: "bankServiceType.list",
            component: () =>
                import("@pages/bank-service-type/Index.vue"),
            meta: {
                title: "List Bank Service Types",
            },
        },
        {
            path: "bank/bank-service-type/:bank/create",
            name: "bankServiceType.create",
            component: () =>
                import("@pages/bank-service-type/Create.vue"),
            meta: {
                title: "Create Bank Service Types",
            },
        },
        {
            path: "bank-service-type/:id/edit",
            name: "bankServiceType.edit",
            component: () =>
                import("@pages/bank-service-type/Create.vue"),
            meta: {
                title: "Edit Bank Service Types",
            },
        },
        {
            path: "kyc",
            name: "kyc.index",
            component: () =>
                import("@pages/kyc/Index.vue"),
            meta: {
                title: "List KYC",
            },
        },
        {
            path: "kyc/:id/view",
            name: "kyc.view",
            component: () =>
                import("@pages/kyc/Detail.vue"),
            meta: {
                title: "KYC Details",   
            },
        },

        {
            path: "bima-account",
            component: Parent,
            children: resourceUrl("bima-account", "bima-accounts"),
        },
        {
            path: "bima",
            component: Parent,
            children: resourceUrl("bima", "bimas"),
        },

        {
            path: "bima/bima-account-type/:bima",
            name: "bimaAccountType.list",
            component: () =>
                import("@pages/bima-account-type/Index.vue"),
            meta: {
                title: "List Bima Account Types",
            },
        },
        {
            path: "bima/bima-account-type/:bima/create",
            name: "bimaAccountType.create",
            component: () =>
                import("@pages/bima-account-type/Create.vue"),
            meta: {
                title: "Create Bima Account Types",
            },
        },
        {
            path: "bima-account-type/:id/edit",
            name: "bimaAccountType.edit",
            component: () =>
                import("@pages/bima-account-type/Create.vue"),
            meta: {
                title: "Edit Bima Account Types",
            },
        },
        {
            path: "loan",
            component: Parent,
            children: resourceUrl("loan", "loans"),
        },
        
        {
            path: "bank/bank-loan-type/:bank",
            name: "bankLoanType.list",
            component: () =>
                import("@pages/bank-loan-type/Index.vue"),
            meta: {
                title: "List Bank Loan Types",
            },
        },
        {
            path: "bank/bank-loan-type/:bank/create",
            name: "bankLoanType.create",
            component: () =>
                import("@pages/bank-loan-type/Create.vue"),
            meta: {
                title: "Create Bank Loan Types",
            },
        },
        {
            path: "bank-loan-type/:id/edit",
            name: "bankLoanType.edit",
            component: () =>
                import("@pages/bank-loan-type/Create.vue"),
            meta: {
                title: "Edit Bank Loan Types",
            },
        },
        {
            path: "service-request",
            name: "serviceRequest.index",
            component: () =>
                import("@pages/service-request/Index.vue"),
            meta: {
                title: "List Service Request",
            },
        },
        {
            path: "service-request/:id/view",
            name: "serviceRequest.view",
            component: () =>
                import("@pages/service-request/Detail.vue"),
            meta: {
                title: "Service Request Details",
            },
        },
        {
            path: "service-provider",
            component: Parent,
            children: resourceUrl("service-provider", "service-providers"),
        },
        {
            path: "*",
            redirect: {
                name: "home",
            },
        },
    ],
}, ];


const router = createRouter({
    history: createWebHistory(),
    routes // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title + " | Dashboard";
    next();
});

export default router;