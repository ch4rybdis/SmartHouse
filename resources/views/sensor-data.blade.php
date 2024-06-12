<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (for icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Stillemeler */
        body {
            background-color: #f0f0f0;
            /* Genel arka plan rengi */
            color: #333;
            /* Genel yazı rengi */
            padding-top: 20px;
        }

        .card {
            background-color: #fff;
            /* Kart arka plan rengi */
            border: 1px solid #ddd;
            /* Kart kenarlık rengi */
            border-radius: 8px;
            /* Kart kenar yuvarlaklığı */
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            /* Kart gölgesi */
        }

        .card-title {
            color: #007bff;
            /* Kart başlık rengi (mavi) */
            font-size: 1.5rem;
            /* Kart başlık font büyüklüğü */
            margin-bottom: 0.75rem;
            /* Kart başlık alt boşluk */
        }

        .card-text {
            font-size: 1.25rem;
            /* Kart metin font büyüklüğü */
            color: #666;
            /* Kart metin rengi */
        }

        .sensor-icon {
            font-size: 4rem;
            /* İkon boyutu */
            margin-bottom: 0.5rem;
            /* İkon alt boşluk */
        }

        .status-on {
            color: green;
            /* Etkin durum renk */
        }

        .status-off {
            color: red;
            /* Pasif durum rengi */
        }

        .status-gray {
            color: gray;
            /* Gri durum rengi */
        }

        .status-blue {
            color: blue;
            /* Mavi durum rengi */
        }

        .status-green {
            color: green;
            /* Yeşil durum rengi */
        }

        .status-red {
            color: red;
            /* Kırmızı durum rengi */
        }
    </style>
</head>

<body>
    <div id="sensor-data" class="container">
        <h1 class="mb-4">Sensor Data</h1>
        <div id="reading-cards" class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Burada veriler dinamik olarak eklenecek -->
        </div>
    </div>

    <!-- Bootstrap JS (for Bootstrap's JavaScript plugins, including Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Veri türlerine göre ikonlar ve renklendirme kuralları
        const sensorIcons = {
            1: {
                icon: 'thermometer-sun',
                label: 'Temperature',
                statusBlue: true,
                thresholds: {
                    low: 15,
                    medium: 30
                }
            },
            2: {
                icon: 'sun',
                label: 'Light',
                statusGreen: true
            },
            3: {
                icon: 'people',
                label: 'Motion',
                statusGreen: true
            },
            5: {
                icon: 'fire',
                label: 'Flame',
                statusGreen: true
            },
            6: {
                icon: 'cone',
                label: 'Distance',
                statusGreen: true
            },
            7: {
                icon: 'droplet',
                label: 'Humidity',
                statusGreen: true
            },
            8: {
                icon: 'cloud',
                label: 'Gas',
                statusGreen: true
            }
        };

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
                var sensorIcon = getSensorIcon(reading.id);
                var sensorStatusClass = reading.value === 1 ? 'status-on' : 'status-off';
                var sensorValueDisplay = getSensorValueDisplay(reading);
                card.innerHTML = `
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-${sensorIcon.icon} sensor-icon ${getSensorStatusClass(reading)}"></i>
                            <h5 class="card-title">${sensorIcon.label}</h5>
                            ${sensorValueDisplay}
                            <p class="card-text">Last Updated: ${formatDateTime(reading.updated_at)}</p>
                        </div>
                    </div>
                `;
                readingCards.appendChild(card);
            });
        }

        function getSensorIcon(sensorId) {
            var defaultIcon = {
                icon: 'question',
                label: 'Unknown Sensor'
            };
            var sensor = sensorIcons[sensorId] || defaultIcon;
            return sensor;
        }

        function getSensorStatusClass(reading) {
            var sensorIcon = sensorIcons[reading.id];
            if (sensorIcon) {
                if (reading.id === 1 && sensorIcon.statusBlue) {
                    return getStatusClassByTemperature(reading.value);
                } else {
                    return reading.value === 1 ? 'status-on' : 'status-off';
                }
            }
            return '';
        }

        function getStatusClassByTemperature(value) {
            var sensorStatusClass = '';
            if (value < sensorIcons[1].thresholds.low) {
                sensorStatusClass = 'status-blue';
            } else if (value >= sensorIcons[1].thresholds.low && value < sensorIcons[1].thresholds.medium) {
                sensorStatusClass = 'status-green';
            } else {
                sensorStatusClass = 'status-red';
            }
            return sensorStatusClass;
        }

        function getSensorValueDisplay(reading) {
            var sensorIcon = sensorIcons[reading.id];
            if (sensorIcon) {
                if (reading.id === 1) {
                    var temperatureColorClass = getStatusClassByTemperature(reading.value);
                    var temperatureDisplay = getTemperatureDisplay(reading.value);
                    return `
                        <p class="card-text ${temperatureColorClass}">${temperatureDisplay}</p>
                    `;
                } else if (reading.id === 6) {
                    // Distance sensörü için özel durum
                    return `
                        <p class="card-text"><i class="bi bi-${sensorIcon.icon}"></i> Distance: ${reading.value} cm</p>
                    `;
                } else if (reading.id === 7) {
                    return `
                        <p class="card-text">Humidity: ${reading.value}</p>
                    `;
                } else {
                    var sensorStatusClass = reading.value === 1 ? 'status-on' : 'status-off';
                    return `
                        <p class="card-text ${sensorStatusClass}">${reading.value === 1 ? 'ON' : 'OFF'}</p>
                    `;
                }
            }
            return '';
        }

        function getTemperatureDisplay(value) {
            if (value < 15) {
                return `Temperature: ${value} °C (Cold)`;
            } else if (value >= 15 && value < 30) {
                return `Temperature: ${value} °C (Moderate)`;
            } else {
                return `Temperature: ${value} °C (Hot)`;
            }
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
