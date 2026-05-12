<!DOCTYPE html>
<html lang="{{str_replace('_', '_', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Tracker</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 font-sans text-white">
<main class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-8">
    <nav class="flex items-center justify-between">
        <a href="/" class="text-lg font-bold">Task Tracker</a>

        <div class="flex items-center gap-3 text-sm">
            @auth
                <a href="{{route('tasks.index')}}" class="rounded-md bg-white px-4 py-2 font-medium text-slate-950">
                    My Tasks
                </a>
            @else<a href="{{route('login')}}" class="text-slate-300 hover:text-white">
                Log in
            </a>

                <a href="{{route('register')}}" class="rounded-md bg-white px-4 py-2 font-medium text-slate-950">
                    Register
                </a>
                @endauth
        </div>
    </nav>

    <section class="grid flex-1 items-center gap-10 py-16 lg:grid-cols-[1fr_420px]">
        <div>
            <p class="mb-4 text-sm font-semibold uppercase tracking-wide text-emerald-300">
                Your personal task
            </p>
            <h1 class="max-w-3xl text-5xl font-bold leading-tight sm:text-6xl">
                Keep today focused, one task at a time.
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Register, log in, and manage your own private task list with a clean laravel app built step by step.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @auth
                    <a href="{{route('tasks.index')}}" class="rounded-md bg-emerald-400 px-5 py-3 font-semibold text-slate-950">
                        Open task
                    </a>
                @else

                <a href="{{route('register')}}" class="rounded-md bg-emerald-400 px-5 py-3 font semibold text-slate-950">
                    Create account
                </a>

                    <a href="{{route('login')}}" class="rounded-md border border-white/20 px-5 py-3 font-semibold text-white">
                        I already have an account
                    </a>
                @endauth
            </div>
        </div>

        <div class="rounded-lg boarder boarder-white/10 bg-white/10 p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="font-semibold">Today</h2>
                <span class="rounded-full bg-emerald-400/20 px-3 py-1 text-sm text-emerald-200">tasks</span>
            </div>

            <div class="space-y-3">
                <div class="rounded-md bg-white p-4 text-slate-900">Plan the next feature</div>
                <div class="rounded-md bg-white p-4 text-slate-900">Write one failing test </div>
                <div class="rounded-md bg-white p-4 text-slate-900">Make the test pass</div>
            </div>

        </div>
    </section>



</main>
</body>

</html>
