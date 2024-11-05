
import './bootstrap';

// 20241105升級Vue 3進行修改
// 確保所有組件都已經正確導入和註冊，在Vue 3中，使用 import 而不是 require。

import { createApp } from 'vue';
import Example from './components/Example.vue';
import NameList from './components/NameList.vue';
import AddrCodeList from './components/AddrCodeList.vue';
import AltnameCodeList from './components/AltnameCodeList.vue';
import AppointCodeList from './components/AppointCodeList.vue';
import TextCodeList from './components/TextCodeList.vue';
import TextInstanceDataList from './components/TextInstanceDataList.vue';
import AddrBelongsDataList from './components/AddrBelongsDataList.vue';
import Addr2CodeList from './components/Addr2CodeList.vue';
import OfficeCodeList from './components/OfficeCodeList.vue';
import SocialInstitutionCodeList from './components/SocialInstitutionCodeList.vue';
import Codebox from './components/codebox.vue';
import SelectVue from './components/Select.vue';
import Select2Vue from './components/Select2Vue.vue';
import Select2 from './components/Select2.vue';
import Select2Addr from './components/Select2Addr.vue';
import PassportClients from './components/passport/Clients.vue';
import PassportAuthorizedClients from './components/passport/AuthorizedClients.vue';
import PassportPersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

const app = createApp({
    components: {
        'example': Example,
        'name-list': NameList,
        'address-code-list': AddrCodeList,
        'altname-code-list': AltnameCodeList,
        'appoint-code-list': AppointCodeList,
        'text-code-list': TextCodeList,
        'text-instance-data-list': TextInstanceDataList,
        'addr-belongs-data-list': AddrBelongsDataList,
        'addr-code-list': Addr2CodeList,
        'office-code-list': OfficeCodeList,
        'social-institution-code-list': SocialInstitutionCodeList,
        'codebox': Codebox,
        'select-vue': SelectVue,
        'select2-vue': Select2Vue,
        'select2': Select2,
        'select2-addr': Select2Addr,
        'passport-clients': PassportClients,
        'passport-authorized-clients': PassportAuthorizedClients,
        'passport-personal-access-tokens': PassportPersonalAccessTokens
    }
}).mount('#app');

