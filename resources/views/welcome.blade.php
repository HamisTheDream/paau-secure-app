<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PAAU SecureApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="theme-color" content="#166534">
    @livewireStyles
</head>
<body class="bg-gray-900 font-sans antialiased flex justify-center h-screen overflow-hidden">

    <div class="w-full max-w-md bg-gray-50 h-full flex flex-col relative shadow-2xl overflow-hidden">
        
        @guest
            <!-- Renders the Login page if the user is not authenticated -->
            <livewire:login />
        @endguest

        @auth
            <!-- Renders the Main App with tabs if the user is authenticated -->
            <livewire:app-shell />
        @endauth

    </div>

    @livewireScripts
</body>
</html>