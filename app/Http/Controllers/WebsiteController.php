<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\JsonResponse;

class WebsiteController extends Controller
{
    public function byClient(int $clientId): JsonResponse
    {
        return response()->json(
            Website::query()
                ->where('client_id', $clientId)
                ->select(['id', 'client_id', 'url', 'last_status', 'last_checked_at'])
                ->orderBy('url')
                ->get()
        );
    }
}
