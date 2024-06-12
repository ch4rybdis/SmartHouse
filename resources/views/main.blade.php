<!DOCTYPE html>
<html>

<head>
    <title>Sensor Data</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <sensor-data></sensor-data>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
