<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Project;
use App\Models\TaskItem;
use App\Models\TaskUser;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        if (auth()->user()->role == 'admin') {

            return [

                Stat::make('Project', Project::count())
                    ->color('primary')
                    ->icon('heroicon-m-briefcase'),

                Stat::make('Client', Client::count())
                    ->color('success')
                    ->icon('heroicon-m-users'),

                Stat::make('Task', TaskItem::count())
                    ->color('warning')
                    ->icon('heroicon-m-clipboard-document-list'),

                Stat::make(
                    'Task Selesai',
                    TaskItem::where('status', 'done')->count()
                )
                    ->color('success')
                    ->icon('heroicon-m-check-circle'),

            ];
        }

        return [
            Stat::make(
                'Task Saya',
                TaskItem::query()
                ->whereHas('task.taskUsers', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->count()
            ),
            Stat::make(
                'Task Selesai',
                TaskItem::where('user_id', auth()->id())
                    ->where('status', 'done')
                    ->count()
            ),
            Stat::make(
                'Deadline Hari Ini',
                TaskItem::query()
                ->whereHas('task.taskUsers', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->whereDate('due_date', today())
                ->where('status', '!=', 'done')
                ->count()
            ),

        ];
    }
}
