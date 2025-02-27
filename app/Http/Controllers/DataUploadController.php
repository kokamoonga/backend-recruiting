<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Metric;
use App\Models\MetricValue;

class DataUploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $file = $request->file('file');
        $contents = file_get_contents($file->getRealPath());

        // Parse CSV string
        $rows = array_map('str_getcsv', explode("\n", $contents));
        $slice = array_slice($rows, 1);

        foreach ($slice as $row) {
            if ($row[0] != null) {
                $metric = Metric::updateOrCreate(['metric_key' => $row[1]]);
                
                MetricValue::updateOrCreate([
                    'metric_id' => $metric->id,
                    'external_id' => $row[2],
                    'achieved_at' => $row[0],
                    'value' => $row[3]
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data uploaded successfully',
        ]);
    }
}
