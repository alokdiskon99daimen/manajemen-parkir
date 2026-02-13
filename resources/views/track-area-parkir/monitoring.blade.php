<x-app-layout>
    <style>
        #dragScroll, 
        #dragScroll * {
            user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -webkit-touch-callout: none;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">
            Monitoring Area Parkir
        </h2>
    </x-slot>

    <div class="bg-gray-100 h-[calc(100vh-80px)] overflow-hidden select-none">
        <div class="h-full max-w-full px-6">

            {{-- DRAG SCROLL CONTAINER --}}
            <div id="dragScroll"
                 class="h-full overflow-x-auto overflow-y-hidden cursor-grab active:cursor-grabbing select-none">

                <div class="flex gap-8 h-full py-6">

                    @foreach ($areas as $area)
                        <div class="min-w-[480px] h-full">
                            <div class="bg-white border rounded-2xl h-full flex flex-col">

                                {{-- HEADER --}}
                                <div class="px-6 py-5 border-b">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-3xl font-bold">
                                                {{ $area['nama_area'] }}
                                            </h3>
                                            <p class="text-base text-gray-500">
                                                {{ $area['lokasi'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTENT --}}
                                <div class="flex-1 p-6 flex flex-col gap-6">

                                    @foreach ($area['details'] as $d)
                                        <div class="border rounded-xl p-6 flex flex-col justify-between h-[170px]">

                                            <div class="flex justify-between items-center">
                                                <span class="text-xl font-semibold capitalize">
                                                    {{ $d['tipe_kendaraan'] }}
                                                </span>
                                                <span class="text-sm text-white px-3 py-1 rounded {{ $d['badge'] }}">
                                                    {{ $d['kondisi'] }}
                                                </span>
                                            </div>

                                            <div class="text-base text-gray-600">
                                                Terisi {{ $d['terisi'] }} / {{ $d['kapasitas'] }}
                                            </div>

                                            <div>
                                                <div class="w-full bg-gray-200 h-4 rounded-full overflow-hidden">
                                                    <div class="{{ $d['badge'] }} h-4"
                                                         style="width: {{ $d['persentase_terisi'] }}%">
                                                    </div>
                                                </div>
                                                <div class="text-right text-sm text-gray-500 mt-1">
                                                    {{ $d['persentase_terisi'] }}%
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        const slider = document.getElementById('dragScroll')

        let isDown = false
        let startX
        let scrollLeft

        slider.addEventListener('mousedown', (e) => {
            isDown = true
            slider.classList.add('cursor-grabbing')
            startX = e.pageX - slider.offsetLeft
            scrollLeft = slider.scrollLeft
        })

        slider.addEventListener('mouseleave', () => {
            isDown = false
            slider.classList.remove('cursor-grabbing')
        })

        slider.addEventListener('mouseup', () => {
            isDown = false
            slider.classList.remove('cursor-grabbing')
        })

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return
            e.preventDefault()
            const x = e.pageX - slider.offsetLeft
            const walk = (x - startX) * 1.5
            slider.scrollLeft = scrollLeft - walk
        })
        slider.addEventListener('dragstart', (e) => e.preventDefault())
    </script>
    @endpush
</x-app-layout>
