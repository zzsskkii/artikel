<?php

namespace App\Http\Controllers;

use App\Models\Reporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporterController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $reporters = Reporter::where('role', 'reporter')->get();

        return response()->json([
            'success' => true,
            'message' => 'List of reporters',
            'data' => $reporters
        ]);
    }
}
