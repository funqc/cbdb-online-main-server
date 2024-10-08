
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*
20240913 提升vue各套件版本至安全版本 by ja
window.Vue = require('vue');
*/
window.Vue = require('vue').default;


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue').default);
Vue.component('name-list', require('./components/NameList.vue').default);
Vue.component('address-code-list', require('./components/AddrCodeList.vue').default);
Vue.component('altname-code-list', require('./components/AltnameCodeList.vue').default);
Vue.component('appoint-code-list', require('./components/AppointCodeList.vue').default);
Vue.component('text-code-list', require('./components/TextCodeList.vue').default);
Vue.component('text-instance-data-list', require('./components/TextInstanceDataList.vue').default);
Vue.component('addr-belongs-data-list', require('./components/AddrBelongsDataList.vue').default);
Vue.component('addr-code-list', require('./components/Addr2CodeList.vue').default);
Vue.component('office-code-list', require('./components/OfficeCodeList.vue').default);
Vue.component('social-institution-code-list', require('./components/SocialInstitutionCodeList.vue').default);
Vue.component('codebox', require('./components/codebox.vue').default);

Vue.component('select-vue', require('./components/Select.vue').default);
Vue.component('select2-vue', require('./components/Select2Vue.vue').default);
Vue.component('select2', require('./components/Select2.vue').default);
Vue.component('select2-addr', require('./components/Select2Addr.vue').default);

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

const app = new Vue({
    el: '#app',
});
