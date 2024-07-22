
import './bootstrap';

import { createApp } from 'vue';
// import { createRouter, createWebHistory } from 'vue-router';

// import Index from "./components/pages/Index.vue";
// import Banner from "./components/pages/Banner/Index.vue"

// const routes = [
//     { path: '/admin/v1', component: Index },
//     { path: '/admin/banner', component: Banner },
// ]

// const router = createRouter({
//     history: createWebHistory(),
//     routes // short for `routes: routes`
// })

// Add a request interceptor
window.axios.interceptors.request.use(
    function (config) {
        // Do something before request is sent
        store.commit("setCardLoading", true);
        return config;
    },
    function (error) {
        // Do something with request error
        store.commit("setCardLoading", false);
        return Promise.reject(error);
    }
);
// Add a response interceptor
window.axios.interceptors.response.use(
    function (response) {
        // Do something with response data
        store.commit("setCardLoading", false);
        return response;
    },
    function (error) {
        // Do something with response error
        store.commit("setCardLoading", false);
        if (
            error.response.status === 401 &&
            error.response.data.message === "Unauthenticated."
        ) {
            location.href = "/admin";
        }
        return Promise.reject(error);
    }
);

import './globals';
//import './filters';
import router from "./routes/route";
import store from "./stores/store";
import App from "./components/pages/layouts/App.vue";
import Card from "./components/material/cards/Card.vue";
import TableSortable from "./components/material/table/TableSortable.vue";
import Actions from "./components/material/table/Actions.vue";
import Pagination from "./components/material/Pagination.vue";
import SortableList from "./components/material/sortable/SortableList.vue";
import Loader from "./components/material/Loader.vue";
import BtnLink from "./components/material/buttons/BtnLink.vue"
import InputText from "./components/material/input/Text.vue";
import ImageContainer from "./components/material/input/Image.vue";
import Checkbox from "./components/material/input/Checkbox.vue";
import Select from "./components/material/input/Select.vue";
import InputTextarea from "./components/material/input/Textarea.vue";
import TextEditor from "./components/material/QuillEditor.vue";
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';


const app = createApp({
    components:{
        "app-container": App,
    },
}).use(router).use(store);


app
    .component('app-sortable-list', SortableList)
    .component('app-pagination', Pagination)
    .component('app-card', Card)
    .component('app-table-sortable', TableSortable)
    .component('app-loader', Loader)
    .component('app-actions', Actions)
    .component('input-image', ImageContainer)
    .component('app-btn-link', BtnLink )
    .component('input-text', InputText)
    .component('input-checkbox', Checkbox)
    .component('input-select', Select)
    .component('input-text-area', InputTextarea)
    .component('app-quill-editor', TextEditor)
    .component(QuillEditor)

app.mount("#app");