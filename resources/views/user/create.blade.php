<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah User
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('user.store') }}" class="space-y-4" onsubmit="return confirm('Apakah anda yakin?')">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama
                    </label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div x-data="{ show: false }" class="relative">
                    <label class="block text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input type="password" name="password" x-bind:type="show ? 'text' : 'password'"
                        class="w-full border border-gray-300 px-3 py-2 rounded
                                focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="button"@click="show = !show" class="absolute right-3 top-7 text-gray-500 hover:text-gray-700">
                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i></button>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Role
                    </label>

                    <select name="role"
                        class="w-full border border-gray-300 px-3 py-2 rounded">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ (isset($userRole) && $userRole == $role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('user.index') }}"
                       class="px-4 py-2 rounded border">
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
