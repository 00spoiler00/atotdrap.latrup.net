<!DOCTYPE html>
<html class="overflow-y-auto" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="manifest" href="/manifest.json">
	@vite('resources/css/app.css')
	@vite(['resources/js/app.js'])
</head>

<body>
	<div id="app" >
		<App />
	</div>
</body>

</html>