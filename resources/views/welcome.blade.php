<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in / Sign up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md border border-gray-200">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome</h1>
            <p class="text-gray-600">Choose an option to continue</p>
        </div>
       
        <div class="space-y-4">
            <a href="{{ route('register') }}"
               class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-xl text-lg text-center transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                📝 Sign up
            </a>
           
            <a href="{{ route('login') }}"
               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl text-lg text-center transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                🔑 Log in
            </a>
        </div>
       
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">Need help? <a href="#" class="text-blue-600 hover:underline">Contact us</a></p>
        </div>
    </div>
</body>
</html>
