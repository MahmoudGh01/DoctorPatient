<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <title>App Layout</title>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

<!-- ===== Header / Navigation ===== -->
<header class="bg-teal-600 shadow-lg">
    <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="text-2xl font-semibold text-white tracking-wide">
            MediBook
        </div>

        <!-- Navigation -->
        <nav class="space-x-6 hidden md:block">
            <a href="/" class="text-teal-50 hover:text-white transition">Home</a>
            <a href="/appointments" class="text-teal-50 hover:text-white transition">Appointments</a>
            <a href="/cabinets" class="text-teal-50 hover:text-white transition">Doctors</a>
            <a href="#" class="text-teal-50 hover:text-white transition">Contact</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-teal-50 hover:text-white focus:outline-none">
            ☰
        </button>
    </div>
</header>


<!-- ===== Main Content ===== -->
<main class="py-10">
    <div class="mx-auto max-w-6xl px-4">

        <!-- Content Slot -->
        <div class="bg-white rounded-xl shadow-md p-6">
            {{$slot}}
        </div>

    </div>
</main>


<!-- ===== Footer ===== -->
<footer class="bg-teal-700 text-teal-100 mt-12">
    <div class="mx-auto max-w-6xl px-4 py-6">

        <div class="flex flex-col md:flex-row justify-between items-center">

            <!-- Left -->
            <p class="text-sm">
                © 2025 MediBook — All Rights Reserved.
            </p>

            <!-- Right -->
            <div class="mt-3 md:mt-0 space-x-4">
                <a href="#" class="hover:text-white text-sm transition">Privacy Policy</a>
                <a href="#" class="hover:text-white text-sm transition">Terms of Service</a>
                <a href="#" class="hover:text-white text-sm transition">Help</a>
            </div>
        </div>

    </div>
</footer>

</body>
</html>
