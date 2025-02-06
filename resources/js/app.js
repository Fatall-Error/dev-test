import './bootstrap';
import { createApp } from 'vue';
import AccountComponent from './components/account/CreateAccount.vue';
import DealComponent from './components/deal/CreateDeal.vue';

// Если на странице есть контейнер для формы аккаунта
if (document.getElementById('app-account-create')) {
    const accountApp = createApp({});
    accountApp.component('create-account', AccountComponent);
    accountApp.mount('#app-account-create');
}



// Если на странице есть контейнер для формы сделки
if (document.getElementById('app-deal-create')) {
    const dealApp = createApp({});
    dealApp.component('create-deal', DealComponent);
    dealApp.mount('#app-deal-create');
}
