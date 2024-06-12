<template>
    <div>
      <h1>Sensor Data</h1>
      <ul>
        <li v-for="reading in readings" :key="reading.id">
          {{ reading.sensor_type }}: {{ reading.value }} ({{ formatDateTime(reading.updated_at) }})
        </li>
      </ul>
      <p v-if="error" style="color: red;">{{ error }}</p>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    props: {
      initialReadings: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        readings: this.initialReadings,
        error: null
      };
    },
    mounted() {
      this.fetchReadings();
      setInterval(this.fetchReadings, 1000); // 1 saniyede bir veri çek
    },
    methods: {
      fetchReadings() {
        axios.get('/api/sensor-readings')
          .then(response => {
            this.readings = response.data;
            this.error = null; // Hata varsa temizle
          })
          .catch(error => {
            console.error('Error fetching readings:', error);
            this.error = 'Error fetching sensor readings. Please try again.'; // Hata mesajı
          });
      },
      formatDateTime(dateTime) {
        const options = {
          year: 'numeric', month: 'numeric', day: 'numeric',
          hour: 'numeric', minute: 'numeric', second: 'numeric',
          hour12: false,
          timeZone: 'UTC' // Zaman dilimini belirleyin
        };
        return new Date(dateTime).toLocaleString('en-US', options); // Tarih ve saat formatı
      }
    },
  };
  </script>
