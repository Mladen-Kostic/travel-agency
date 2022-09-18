require('./bootstrap');

import { createApp } from 'vue';
import Welcome from './components/Welcome';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const app = createApp({});

app.component('welcome', Welcome);
app.component('Datepicker', Datepicker);
app.mount('#app');