<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @vite(['resources/css/app.css', 'resources/ts/app.ts'])
    @inertiaHead

    <link rel="icon" type="image/png" href="{{ asset('contentstash/logo.png') }}">
</head>
<body>
@inertia
</body>
</html>