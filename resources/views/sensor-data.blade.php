<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
</head>

<body>
    <div id="sensor-data">
        <h1>Sensor Data</h1>
        <ul id="reading-list">
            <!-- Burada veriler dinamik olarak eklenecek -->
        </ul>
    </div>

    <script>
        // Belirli aralıklarla verileri güncellemek için setInterval kullanabiliriz
        setInterval(fetchSensorData, 1000); // 1 saniyede bir güncelle

        function fetchSensorData() {
            // AJAX kullanarak verileri GET isteği ile çekiyoruz
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/sensor-readings', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Başarılı cevap aldığımızda verileri güncelliyoruz
                    var readings = JSON.parse(xhr.responseText);
                    updateSensorReadings(readings);
                } else {
                    console.error('Error fetching sensor readings:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Network error fetching sensor readings.');
            };
            xhr.send();
        }

        function updateSensorReadings(readings) {
            var readingList = document.getElementById('reading-list');
            // Mevcut listeyi temizle
            readingList.innerHTML = '';
            // Yeni verileri listeye ekleyin
            readings.forEach(function(reading) {
                var li = document.createElement('li');
                li.textContent = reading.sensor_type + ': ' + reading.value + ' (' + reading.updated_at + ')';
                readingList.appendChild(li);
            });
        }
    </script>
</body>

</html>
