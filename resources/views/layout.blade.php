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
                <div class="flex flex-col">
                    <router-link active-class="active" to="/dashboard" class="text-sm transition duration-150 hover:text-laravel py-2">
                        <i class="fas fa-project-diagram w-4 mr-1"></i>
                        Dashboard
                    </router-link>

                    <router-link active-class="active" to="/workflows/running" class="text-sm transition duration-150 hover:text-laravel py-2">
                        <i class="fas fa-project-diagram w-4 mr-1"></i>
                        Running Workflows
                    </router-link>

                    <router-link active-class="active" to="/workflows/finished" class="text-sm transition duration-150 hover:text-laravel py-2">
                        <i class="fas fa-check w-4 mr-1"></i>
                        Finished Workflows
                    </router-link>

                    <router-link active-class="active" to="/workflows/failed" class="text-sm transition duration-150 hover:text-laravel py-2">
                        <i class="fas fa-times w-4 mr-1"></i>
                        Failed Workflows
                    </router-link>
                </div>
            </div>

            <div class="col-span-3 flex flex-col">
                @if (! $assetsAreCurrent)
                    <div class="alert alert-warning">
                        The published VentureDashboard assets are not up-to-date with the installed version. To update, run:<br/><code>php artisan venture:dashboard:publish</code>
                    </div>
                @endif

                <router-view></router-view>
            </div>
        </div>
    </div>

<!-- Global VentureDashboard Object -->
<script>
    window.VentureDashboard = @json($ventureDashboardScriptVariables);
</script>

</body>
</html>
