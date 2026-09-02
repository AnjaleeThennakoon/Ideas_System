<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea</title>
    @vite('resources/css/app.css')
</head>
<body class=" bg-background text-foreground">

 <x-layout.nav/>

    <main class="max-w-7xl mx-auto px-6 py-6">

        {{ $slot }}
    </main>



    @session('success')
        <div
             x-data="{ show:true }"
             x-init="setTimeout(() => show =false , 3000"
             x-show="show"
             x-transittion.opacity.duration.3000ms
            class="bg-primary px-4 py-3 absolute bottom-4 righ-4 rounded-lg">

            {{ $value }}
        </div>
    @endsession


</body>
</html>
