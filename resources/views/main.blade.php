<!-- resources/views/sensor_data.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
</head>

<body>
    <div id="app">
        <sensor-data-component :initial-readings="{{ json_encode($readings) }}"></sensor-data-component>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>


</body>

</html>
