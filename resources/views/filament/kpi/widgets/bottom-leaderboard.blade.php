<x-filament-widgets::widget>

    <x-filament::section>

        <x-slot name="heading">
            📉 Perlu Perhatian
        </x-slot>

        <div class="space-y-4">

            @forelse($this->getLeaders() as $leader)
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">

                    <div class="flex justify-between">

                        <div>

                            <div class="font-bold text-lg">

                                {{ $this->rankIcon($loop->iteration) }}

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
                                    class="inline-flex rounded-full bg-danger-100 px-2 py-1 text-xs font-semibold text-danger-700">

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

                <div class="py-8 text-center text-gray-500">

                    Belum ada data.

                </div>
            @endforelse

        </div>

    </x-filament::section>

</x-filament-widgets::widget>
