<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}@yield('title')</title>

    {{-- Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    {{-- Bootstrap用JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/design.css') }}" />
    @livewireStyles

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="antialiased">
    <main id="main" data-dashboardurl={{ route('dashboard') }} data-loginurl={{ route('login') }}
        data-logouturl={{route('logout') }} data-registerurl={{ route('register') }} data-mypageurl={{ route('mypage')
        }} data-threadhistoryurl={{ route('thread.history') }} data-profileshowurl={{ route('profile.show') }}
        data-hubindexurl={{ route('hub.index') }} data-username={{ Auth::check() && Auth::user()->
        hasVerifiedEmail()
        ? Auth::user()->name : null }}
        >
        @yield("main")
    </main>

    @livewireScripts
</body>

</html>
