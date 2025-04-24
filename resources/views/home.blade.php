<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">

        <title>Wordpress And Shopify Development Contact to me!</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <!-- Only load tracking scripts if consent given -->
    @if (app(\App\Services\CookieConsentService::class)->getConsent()?->categories['analytics'] ?? false)
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID', { 
                'anonymize_ip': true,
                'allow_ad_personalization_signals': {{ 
                    app(\App\Services\CookieConsentService::class)->getConsent()?->categories['marketing'] 
                        ? 'true' : 'false' 
                }}
            });
        </script>
    @endif
    
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <script type="module">
        // import Test from "./../resources/views/components/Test.vue";
    </script>
    <body class="antialiased">
        
        <div id="app" class="app">
        </div>
    </body>
</html>
