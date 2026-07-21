<x-filament-widgets::widget>

    <x-filament::section>

        <x-slot name="heading">
            🏆 Top Performer
        </x-slot>

        <div class="space-y-4">

            @forelse($this->getLeaders() as $leader)
                <div
                    class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition">

                    <div class="flex justify-between items-start">

                        <div>

                            <div class="text-lg font-bold">

                                {{ $this->medal($loop->iteration) }}

                                {{ $leader->user->name }}

                            </div>

                            <div class="text-sm text-gray-500">

                                {{ ucfirst($leader->user->role) }}

                            </div>

                        </div>

                        <div class="text-right">

                            <div class="text-2xl font-bold">

                                {{ number_format($leader->total_score, 2) }}

                            </div>

                            <div>

                                <span
                                    class="inline-flex rounded-full bg-success-100 px-2 py-1 text-xs font-semibold text-success-700">

                                    Grade {{ $leader->grade }}

                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="w-full bg-gray-200 rounded-full h-2">

                            <div class="{{ $this->progressColor($leader->total_score) }} h-2 rounded-full"
                                style="width: {{ min($leader->total_score, 100) }}%">
                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center text-gray-500 py-8">

                    Belum ada data KPI.

                </div>
            @endforelse

        </div>

    </x-filament::section>

</x-filament-widgets::widget>
