<?php

namespace MichaelOrenda\Logging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MichaelOrenda\Logging\Models\SecurityLog;

class SecurityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SecurityLog::query()
            ->latest()
            ->when($request->event, fn ($q) => $q->where('event', $request->event))
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id));

        return response()->json([
            'success' => true,
            'data' => $query->paginate(20),
        ]);
    }
}
