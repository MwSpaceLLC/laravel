<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://www.mwspace.com">
    <link rel="preconnect" href="https://cdn.tailwindcss.com">

    <link rel="prefetch" href="https://cdn.tailwindcss.com/3.4.1">
    <link rel="prefetch" href="https://www.mwspace.com/favicon.ico">

    <title>@yield('title')</title>

    <link rel="icon" type="image/png" sizes="32x32" href="https://www.mwspace.com/favicon.ico">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 mx-auto max-w-7xl px-8 flex justify-center items-center h-screen">

<main class="antialiased relative">
    <div class="max-w-7xl h-screen justify-start items-center flex mx-auto pt-10 pb-12 px-4 lg:pb-16">
        <section class="max-w-4xl flex items-start flex-col w-full my-4 mx-auto">
            <div class="flex items-center justify-center py-4">

                <svg width="100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1518.28 924.56">
                    <path
                        d="M1483.75 315.27C889.32 504.21 771.5 924.56 771.5 924.56s-48.81-41.93-69.13-83.77c0 0-21.72-261.58 16.12-481.25C450.32 667.83 440 906 440 906s-61.11-26.15-82.79-74.09c0 0-71.76-298.76-43.88-515.41-59.52 141.15-89.2 303.18-91.67 524.3l-66.88-67.5C103.12 688.28-6.83 475.54.33 325.88c0 0 61.55 23.38 86 41.4 0 0 3.76 114.33 37.54 244.61-13.09-121.25-11.21-295.38 62.77-467.52C339.48 71.44 454 75.76 454 75.76s-32.14 250-38.83 486.46C466.31 419.09 562.61 232.43 743.9 36.1c72.62-26 242-3.18 302.52 23.88-1.49 1.94-156.36 203.9-239.83 530.68 107-191.06 313.76-445.5 695.6-590.66 30.39 94.48 14.03 202.17-18.44 315.27Z"
                        data-name="Livello 2" style="fill:#fff"/>
                </svg>
            </div>
            <p class="text-xl text-gray-200"><b>@yield('code').</b> @yield('message')</p>
            <p class="text-md font-mono max-w-xl text-gray-200">{{__('That’s all we know')}}</p>
        </section>
    </div>
</main>

</body>
</html>
