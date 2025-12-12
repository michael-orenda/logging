<?php

namespace MichaelOrenda\Logging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MichaelOrenda\Logging\Models\ErrorLog;

class ErrorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ErrorLog::query()
            ->latest()
            ->when($request->severity, fn ($q) => $q->where('severity', $request->severity));

        return response()->json([
            'success' => true,
            'data' => $query->paginate(20),
        ]);
    }
}
