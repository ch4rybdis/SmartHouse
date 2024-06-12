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
  export default {
    data() {
      return {
        readings: [],
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
          })
          .catch(error => {
            console.error('Error fetching readings:', error);
          });
      },
    },
  };
  </script>
