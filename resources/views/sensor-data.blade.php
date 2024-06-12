<!-- resources/views/sensor-data.blade.php veya plain HTML dosyası -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
</head>

<body>
    <div id="app">
        <sensor-data-component></sensor-data-component>
    </div>

    <!-- Vue.js ve Axios kütüphanelerini dahil et -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Vue bileşeni bağlama -->
    <script src="{{ asset('js/components/SensorDataComponent.vue') }}"></script>

    <!-- Vue uygulamasını oluşturma -->
    <script>
        new Vue({
            el: '#app',
            components: {
                'sensor-data-component': window['SensorDataComponent'] // Bileşen adı ile eşleştirme yapılmalıdır
            }
        });
    </script>
</body>

</html>
