/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('tinymce');
require('tinymce/themes/silver');
require('tinymce/themes/mobile');
require('tinymce/plugins/paste');
require('tinymce/plugins/advlist');
require('tinymce/plugins/autolink');
require('tinymce/plugins/lists');
require('tinymce/plugins/link');
require('tinymce/plugins/image');
require('tinymce/plugins/charmap');
require('tinymce/plugins/print');
require('tinymce/plugins/preview');
require('tinymce/plugins/anchor');
require('tinymce/plugins/textcolor');
require('tinymce/plugins/searchreplace');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/code');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/media');
require('tinymce/plugins/table');
require('tinymce/plugins/contextmenu');
require('tinymce/plugins/code');
require('tinymce/plugins/help');
require('tinymce/plugins/wordcount');

$( document ).ready(function() {
    tinymce.init({
        selector: ".tiny",
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code help wordcount'
        ],
        toolbar: 'insert insertfile | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
        relative_urls: false,
        file_picker_callback: function (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            let type = 'image' === meta.filetype ? 'Images' : 'Files',
                url  = '/' + 'laravel-filemanager?editor=tinymce5&type=' + type;

            tinymce.activeEditor.windowManager.openUrl({
                url : url,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        },
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
});


//require('./bootstrap');
require('admin-lte');

window.axios = require('axios');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform'
import Swal from 'sweetalert2'
import QS from 'qs';
import Moment from 'moment';
import Gate from "./Gate"


//import NoUISlider from 'nouislider'
// import VuneSessionStorage from 'vue-sessionstorage'

window.swal= Swal;
window.qs = QS;
window.moment = Moment;
/**
 * Vform Code is written here... *
 */
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
// Vue.use(VueSessionStorage);

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.prototype.$gate = new Gate(window.user_role_name);

/**
 * Vue Router Code is written here... *
 */
import VueRouter from 'vue-router'
Vue.use(VueRouter);
const routes = [
    //{ path: '/detail',name:'detail', component: require('./components/ProductDetailPage.vue').default , props: route => ({ pid: route.query.pid }) },
    //{ path: '/detail/:ProductId',name:'detail', component: require('./components/ProductDetailPage.vue').default },
      { path: '/panel/users',name:'pusers', component: require('./components/PanelUsers.vue').default },
      { path: '/panel/control',name:'pcontrol', component: require('./components/PanelTagBrandCategory.vue').default },
      { path: '/panel/developer',name:'pdeveloper', component: require('./components/Developer.vue').default },
      { path: '/panel/product_media',name:'pmedia', component: require('./components/ProductMedia.vue').default },
      { path: '/panel/product_add',name:'paddproduct', component: require('./components/PanelAddProduct.vue').default },
      { path: '/panel/product_edit/:ProductId',name:'peditproduct',props: true, component: require('./components/PanelEditProduct.vue').default },
      { path: '/panel/product_view',name:'pviewproduct', component: require('./components/PanelViewProduct.vue').default },
];
const router = new VueRouter({
    mode: 'history',
    routes: routes// short for `routes: routes`
});




// import { SliderPlugin } from "@syncfusion/ej2-vue-inputs";
// Vue.use(SliderPlugin);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('welcome-content-factory', require('./components/WelcomeContentFactory.vue').default);
Vue.component('order-page', require('./components/OrderPageComponent.vue').default);
Vue.component('product-detail', require('./components/ProductDetailPage.vue').default);
Vue.component('category-page', require('./components/CategoryPageFactory.vue').default);
Vue.component('product-edit', require('./components/PanelEditProduct.vue').default);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.filter('myDate',function(created_at){
    return moment(created_at).format('MMMM Do YYYY');
});

Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = Toast;

//making a custom event
let Fire = new Vue();
window.Fire = Fire;

const app = new Vue({
    el: '#app',
    router,
    data:{
        orders:[],
        basketCount:0,
        query:''
    },
    methods:{
       SaveOrder(Id,Quantity)
       {
           //console.log('here...');
           this.orders.push({Id,Quantity});
           this.basketCount = this.basketCount + 1;

           localStorage.orders = JSON.stringify(this.orders);
           localStorage.basketCount = this.basketCount;
       },
        GetOrders(){
           return this.orders;
        },
        SearchProduct(query){
           this.query = query;
           localStorage.query = this.query;
        }
    },
    mounted(){
        // this.$session.set('name', 'koorosh');
        if(localStorage.orders) this.orders = JSON.parse(localStorage.orders);
        if(localStorage.basketCount) this.basketCount = parseInt(localStorage.basketCount);
        if(localStorage.query) this.query = localStorage.query;
    }

});

window.app = app;
window.router = router;
