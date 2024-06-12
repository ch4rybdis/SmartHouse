// resources/js/app.js

require('./bootstrap');

import Vue from 'vue';
import SensorDataComponent from './components/SensorDataComponent.vue';

const app = new Vue({
  el: '#app',
  components: {
    SensorDataComponent,
  },
});
