<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Backup & Restore Database
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- EXPORT --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Backup Database</h3>
                <p class="text-sm text-gray-600 mb-3">
                    Download seluruh database dalam bentuk file <b>.sql</b>
                </p>

                <a href="{{ route('database.export.sql') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Download Backup (.sql)
                </a>
            </div>

            <hr class="my-6">

            {{-- IMPORT --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Restore Database</h3>
                <p class="text-sm text-gray-600 mb-3">
                    Upload file <b>.sql</b> untuk me-restore database
                </p>

                <form action="{{ route('database.import') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="file"
                           name="file"
                           accept=".sql"
                           required
                           class="mb-4 block w-full text-sm">

                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Restore Database
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
