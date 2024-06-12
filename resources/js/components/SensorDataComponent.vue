<!-- resources/js/components/SensorDataComponent.vue -->
<template>
    <div>
      <h1>Sensor Data</h1>
      <ul>
        <li v-for="reading in readings" :key="reading.id">
          {{ reading.sensor_type }}: {{ reading.value }} ({{ reading.updated_at }})
        </li>
      </ul>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'SensorDataComponent', // Bileşen ismi burada tanımlanmalıdır
    data() {
      return {
        readings: []
      };
    },
    mounted() {
      this.fetchReadings(); // Sayfa yüklendiğinde ilk veriyi al
      setInterval(this.fetchReadings, 2000); // 2 saniyede bir veriyi güncelle
    },
    methods: {
      fetchReadings() {
        axios.get('/api/sensor-readings')
          .then(response => {
            this.readings = response.data;
          })
          .catch(error => {
            console.error('Error fetching readings:', error);
          });
      },
    },
  };
  </script>
