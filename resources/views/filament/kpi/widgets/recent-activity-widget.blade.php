<x-filament-widgets::widget>

    <x-filament::section>

        <x-slot name="heading">
            📋 Aktivitas Terakhir
        </x-slot>

        <div class="space-y-4">

            @forelse($this->getActivities() as $activity)
                <div class="border-l-4 border-primary-500 pl-4">

                    <div class="font-semibold">

                        {{ $activity['title'] }}

                    </div>

                    <div class="text-sm text-gray-500 mt-1">

                        👤 {{ $activity['employee'] }} Karyawan

                        •

                        ✅ {{ $activity['completed'] }} Task

                        •

                        ⏰ {{ $activity['late'] }} Terlambat

                    </div>

                    <div class="text-xs text-gray-400 mt-1">

                        {{ $activity['created_at']->diffForHumans() }}

                    </div>

                </div>

            @empty

                <div class="text-center py-8 text-gray-500">

                    Belum ada aktivitas.

                </div>
            @endforelse

        </div>

    </x-filament::section>

</x-filament-widgets::widget>
