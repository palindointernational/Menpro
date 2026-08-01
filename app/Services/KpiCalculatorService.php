<?php

namespace App\Services;

use App\Models\KpiIndicator;
use App\Models\KpiPeriod;
use App\Models\KpiScore;
use App\Models\KpiSummarie;
use App\Models\User;
use App\Models\TaskItem;
use App\Models\TaskResult;

class KpiCalculatorService
{
    public function generate(KpiPeriod $period): void
    {
        KpiScore::where('period_id', $period->id)->delete();
        KpiSummarie::where('period_id', $period->id)->delete();

        $users = User::where('role', '!=', 'admin')->get();

        foreach ($users as $user) {

            $totalScore = 0;
            $indicators = KpiIndicator::get();

            foreach ($indicators as $indicator) {
                $rawValue = $this->calculateIndicator($user, $indicator, $period);
                $score = ($rawValue / $indicator->max_score) * $indicator->weight;

                KpiScore::create([
                    'period_id' => $period->id,
                    'user_id' => $user->id,
                    'indicator_id' => $indicator->id,
                    'raw_value' => $rawValue,
                    'score' => round($score, 2),
                ]);

                $totalScore += $score;
            }

            KpiSummarie::create([
                'period_id'      => $period->id,
                'user_id'        => $user->id,
                'total_score'    => round($totalScore, 2),
                'grade'          => $this->grade($totalScore),
                'completed_task' => $this->completedTask($user, $period),
                'late_task'      => $this->lateTask($user, $period),
                'approved_task'  => $this->approvedTask($user, $period),
                'revision_task'  => $this->revisionTask($user, $period),
            ]);
        }
    }

    protected function completedTask(User $user, KpiPeriod $period): int
    {
        return TaskItem::where('user_id', $user->id)
            ->where('status', 'done')
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();
    }
    protected function lateTask(User $user, KpiPeriod $period): int
    {
        return TaskItem::where('user_id', $user->id)
            ->where('status', 'done')
            ->whereColumn('completed_at', '>', 'due_date')
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();
    }

    protected function approvedTask(User $user, KpiPeriod $period): int
    {
        return TaskResult::where('status', 'approved')
            ->whereHas('taskItem', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();
    }

    protected function calculateIndicator(User $user, KpiIndicator $indicator, KpiPeriod $period): float
    {
        return match ($indicator->formula) {

            'task_completion' => $this->taskCompletion($user, $period),

            'on_time_completion' => $this->onTimeCompletion($user, $period),

            'revision_rate' => $this->revisionRate($user, $period),

            default => 0,
        };
    }

    protected function revisionTask(User $user, KpiPeriod $period): int
    {
        return TaskResult::whereHas('taskItem', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->sum('revision');
    }

    protected function taskCompletion(User $user, KpiPeriod $period): float
    {
        $total = TaskItem::where('user_id', $user->id)
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();

        if ($total == 0) {
            return 0;
        }

        $completed = TaskItem::where('user_id', $user->id)
            ->where('status', 'done')
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();

        return round(($completed / $total) * 100, 2);
    }

    protected function onTimeCompletion(User $user, KpiPeriod $period): float
    {
        $completed = TaskItem::where('user_id', $user->id)
            ->where('status', 'done')
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ]);

        $total = (clone $completed)->count();

        if ($total == 0) {
            return 0;
        }

        $onTime = (clone $completed)
            ->whereColumn('completed_at', '<=', 'due_date')
            ->count();

        return round(($onTime / $total) * 100, 2);
    }

    protected function revisionRate(User $user, KpiPeriod $period): float
    {
        $totalTask = TaskItem::query()
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();

        if ($totalTask === 0) {
            return 0;
        }

        $revision = TaskResult::query()
            ->where('status', 'rejected')
            ->whereHas('taskItem', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereBetween('created_at', [
                $period->start_date,
                $period->end_date,
            ])
            ->count();

        $revisionRate = ($revision / $totalTask) * 100;

        return round(100 - $revisionRate, 2);
    }

    protected function grade(float $score): string
    {
        return match (true) {

            $score >= 90 => 'A',

            $score >= 80 => 'B',

            $score >= 70 => 'C',

            $score >= 60 => 'D',

            default => 'E',
        };
    }

    protected function remark(float $score): string
    {
        return match (true) {

            $score >= 90 => 'Sangat Baik',

            $score >= 80 => 'Baik',

            $score >= 70 => 'Cukup',

            $score >= 60 => 'Kurang',

            default => 'Sangat Kurang',
        };
    }
}
