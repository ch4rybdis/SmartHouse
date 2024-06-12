<template>
  <div>
    <h1>Sensor Data</h1>
    <ul>
      <li v-for="data in sensorData" :key="data.id">
        ID: {{ data.id }}, Type: {{ data.sensor_type }}, Value: {{ data.value }}, Updated At: {{ data.updated_at }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sensorData: []
    };
  },
  mounted() {
    this.fetchData();
    this.startAutoRefresh();
  },
  methods: {
    fetchData() {
      axios.get('/api/sensor')
        .then(response => {
          this.sensorData = response.data;
        })
        .catch(error => {
          console.error('Error fetching sensor data:', error);
        });
    },
    startAutoRefresh() {
      setInterval(this.fetchData, 1000); // Verileri her 1 saniyede bir yenile
    }
  }
};
</script>
