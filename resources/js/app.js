// resources/js/app.js

require('./bootstrap');

import { createApp } from 'vue';
import SensorDataComponent from './components/SensorDataComponent.vue';

const app = createApp({});
app.component('sensor-data-component', SensorDataComponent);
app.mount('#app');
