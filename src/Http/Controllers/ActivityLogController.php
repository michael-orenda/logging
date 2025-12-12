<?php

namespace MichaelOrenda\Logging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MichaelOrenda\Logging\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query()
            ->latest()
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->action, fn ($q) => $q->where('action', $request->action));

        return response()->json([
            'success' => true,
            'data' => $query->paginate(20),
        ]);
    }
}
