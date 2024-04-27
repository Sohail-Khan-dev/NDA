<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>NDA</title>
    </head>
<body>
<div class="bg-gray-900  p-6">
    <h1 class="text-white text-center text-2xl"> Welcome to the NDS </h1>
</div>
<div class="flex flex-row w-full bg-gray-100 gap-3">
    <div class="container w-1/3 mx-auto mt-8 shadow bg-gray-200 mx-3">
        <div class="max-w bg-white p-6 rounded shadow my-2">
            <h2 class="text-2xl font-bold mb-4 bg-gray-700 text-white text-center py-4">Create User</h2>
            <form method="POST" action="{{ url('/api/register') }}">

            @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" class="form-input w-full" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="email" class="form-input w-full" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-input w-full" value="{{ old('phone_number') }}" required>
                </div>

                <div class="mb-4">
                    <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth:</label>
                    <input type="date" name="dob" id="dob" class="form-input w-full" value="{{ old('dob') }}">
                </div>

                <div class="mb-4">
                    <label for="id_number" class="block text-gray-700 text-sm font-bold mb-2">ID Number:</label>
                    <input type="text" name="id_number" id="id_number" class="form-input w-full" value="{{ old('id_number') }}">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                    <input type="password" name="password" id="password" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create User</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container w-2/3 mx-auto mt-8 shadow bg-gray-200 mr-3">
        <div class="max-w bg-white p-6 rounded shadow my-2">
            <h2 class="text-2xl font-bold mb-4 bg-gray-700 text-white text-center py-4">All User</h2>
            @if($users)
                <div class="container mx-auto mt-8">
                    <h2 class="text-2xl font-bold mb-4 bg-gray-700 text-white text-center py-4">Users List</h2>
                    <table class="w-full">
                        <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Phone Number</th>
                            <th class="border px-4 py-2">Date of Birth</th>
                            <th class="border px-4 py-2">ID Number</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->id }}</td>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->phone_number }}</td>
                                <td class="border px-4 py-2">{{ $user->dob }}</td>
                                <td class="border px-4 py-2">{{ $user->id_number }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p> There is no User in the Databse </p>
            @endif

        </div>
    </div>
</div>
</body>

</html>
