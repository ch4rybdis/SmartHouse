<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Bootstrap Icons (for icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div id="sensor-data" class="container mt-4">
        <h1 class="mb-4">Sensor Data</h1>
        <div id="reading-cards" class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Burada veriler dinamik olarak eklenecek -->
        </div>
    </div>

    <!-- Bootstrap JS (for Bootstrap's JavaScript plugins, including Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

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
            var readingCards = document.getElementById('reading-cards');
            // Mevcut kartları temizle
            readingCards.innerHTML = '';
            // Yeni verileri kartlar halinde göster
            readings.forEach(function(reading) {
                var card = document.createElement('div');
                card.className = 'col';
                card.innerHTML = `
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">${reading.sensor_type}</h5>
                            <p class="card-text">Value: ${reading.value}</p>
                            <p class="card-text">Last Updated: ${formatDateTime(reading.updated_at)}</p>
                        </div>
                    </div>
                `;
                readingCards.appendChild(card);
            });
        }

        function formatDateTime(dateTime) {
            var date = new Date(dateTime);
            return date.toLocaleString('en-US', {
                hour12: false,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
    </script>
</body>

</html>
