<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased" style="background-image: url('/images/login.jpeg'); background-size: cover; background-position: center;">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md rounded-lg shadow-lg p-6" style="background-color: #c3e4ff;">
            <div class="text-center mb-4">
                <h1 class="text-2xl font-bold">Change Password</h1>
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required 
                            class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    </div>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required 
                            class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    </div>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" 
                        class="w-full px-4 py-2 text-white rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300" style="background-color: #003366;">
                        Submit
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-blue-900 hover:underline text-center">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    @vite('resources/js/app.js')
</body>
</html>