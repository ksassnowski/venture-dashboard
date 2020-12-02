<!DOCTYPE html>
<html class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ asset(mix('app.css', 'vendor/venture-dashboard')) }}" rel="stylesheet" />
    <script src="{{ asset(mix('app.js', 'vendor/venture-dashboard')) }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body class="h-full flex flex-col bg-gray-100 pt-10">
    <div id="app" class="mx-auto w-full max-w-5xl px-4 lg:px-0 flex-1 flex flex-col pb-10">
        <div class="mb-8">
            <img src="{{ asset('vendor/venture-dashboard/img/logo.svg') }}" class="w-auto h-10" />
        </div>

        <div class="grid grid-cols-4 gap-4 flex-1">
            <div class="col-span-1 pt-4">
                @include('venture-dashboard::partials.navigation')
            </div>

            <div class="col-span-3 flex flex-col">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
