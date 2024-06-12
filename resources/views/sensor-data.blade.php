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
        <div id="reading-cards" class="card-deck">
            <!-- Burada veriler dinamik olarak eklenecek -->
        </div>
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
            var readingCards = document.getElementById('reading-cards');
            // Mevcut kartları temizle
            readingCards.innerHTML = '';
            // Yeni verileri kartlar halinde göster
            readings.forEach(function(reading) {
                var card = document.createElement('div');
                card.className = 'card mb-3';
                var cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                var cardTitle = document.createElement('h5');
                cardTitle.className = 'card-title';
                cardTitle.textContent = reading.sensor_type;
                var cardText = document.createElement('p');
                cardText.className = 'card-text';
                cardText.textContent = 'Value: ' + reading.value;
                var cardTimestamp = document.createElement('p');
                cardTimestamp.className = 'card-text';
                cardTimestamp.textContent = 'Last Updated: ' + formatDateTime(reading.updated_at);
                cardBody.appendChild(cardTitle);
                cardBody.appendChild(cardText);
                cardBody.appendChild(cardTimestamp);
                card.appendChild(cardBody);
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
