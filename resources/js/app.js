require('./bootstrap');

import Vue from 'vue';
import SensorData from './components/SensorData.vue';

const app = new Vue({
    el: '#app',
    components: {
        SensorData
    }
});
