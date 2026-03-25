<?php

namespace App\Services\Reporting;

use App\Booking;
use App\BillPayment;
use App\Customer;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportingService
{
    public function getDashboardStats(): array
    {
        $patientRole = Role::where('name', 'patient')->first();

        $patientsQuery = Customer::query();
        if ($patientRole) {
            $patientsQuery->where('role_id', $patientRole->id);
        }

        $totalPatients = (int) $patientsQuery->count();
        $totalAppointments = (int) Booking::query()->count();

        $now = Carbon::now('Australia/Melbourne');
        $start = $now->copy()->subMonths(5)->startOfMonth();
        $end = $now->copy()->endOfMonth();

        $totalRevenue = $this->getRevenueBetween($start, $end);
        $revenueByMonth = $this->getRevenueByMonth($start, $end);

        return [
            'totalPatients' => $totalPatients,
            'totalAppointments' => $totalAppointments,
            'totalRevenue' => $totalRevenue,
            'revenueByMonth' => $revenueByMonth,
            'start' => $start,
            'end' => $end,
        ];
    }

    private function getRevenueBetween(Carbon $start, Carbon $end): float
    {
        return (float) BillPayment::query()
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->sum('amount');
    }

    private function getRevenueByMonth(Carbon $start, Carbon $end): array
    {
        // Simple approach: load payments in range then group in PHP (small data for student app).
        $payments = BillPayment::query()
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->get(['amount', 'paid_at']);

        $months = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $months[] = $cursor->format('M Y');
            $cursor->addMonth();
        }

        $map = array_fill_keys($months, 0.0);

        /** @var Collection $payments */
        foreach ($payments as $p) {
            $label = Carbon::parse($p->paid_at)->format('M Y');
            if (isset($map[$label])) {
                $map[$label] += (float) $p->amount;
            }
        }

        return [
            'labels' => array_values($months),
            'values' => array_map(fn ($v) => (float) $v, array_values($map)),
        ];
    }
}

