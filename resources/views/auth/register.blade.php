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
                <h1 class="text-2xl font-bold">Register</h1>
                <p class="text-gray-500">Create your account!</p>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mt-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('phone_number')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                        class="mt-1 block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-900 focus:border-blue-900 placeholder-gray-400 text-sm text-gray-900">
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-blue-900 hover:underline rounded-md focus:outline-none" 
                    href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit" 
                        class="ms-4 px-4 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 focus:ring focus:ring-blue-300">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    @vite('resources/js/app.js')
</body>
</html>
