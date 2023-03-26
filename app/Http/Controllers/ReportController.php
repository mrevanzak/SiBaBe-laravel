<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Report;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $reports = Report::whereDate('date', '>=', now()->startOfYear())
            ->whereDate('date', '<=', now()->endOfYear())
            ->get()->toArray();
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_name = DateTime::createFromFormat('!m', $month)->format('F');
            $matching_reports = array_filter($reports, function ($report) use ($month_name) {
                return Carbon::parse($report['date'])->format('F') === $month_name;
            });

            $data[] = [
                'month' => $month_name,
                'year' => now()->year,
                'report' => array_values($matching_reports),
            ];
        }

        return $this->success(
            'Success get monthly report',
            $data
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'name' => 'required|string',
            'totalPrice' => 'required|integer',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Failed to create report',
                $validator->errors()->first(),
                400
            );
        }

        $production = Production::create([
            'date' => $request->date,
            'name' => $request->name,
            'total_cost' => $request->totalPrice,
        ]);

        if (! $production) {
            return $this->error(
                'Failed to create report',
                'Failed to create report',
                400
            );
        }

        $report = Report::firstOrNew([
            'date' => $request->date,
        ]);
        $report->expense += $request->totalPrice;
        $report->save();

        return $this->success(
            'Success create report',
            $production,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    //
    }
}
