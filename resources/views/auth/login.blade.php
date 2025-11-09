<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | SIPANDAKABULAN</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-800 via-blue-600 to-blue-400 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-700">SIPANDAKABULAN</h1>
            <p class="text-gray-500 text-sm">Sistem Pendataan Kabupaten Layak Anak</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-gray-600 text-sm">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition duration-200">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Dinas Sosial Kabupaten Tasikmalaya
        </p>
    </div>

</body>
</html>
