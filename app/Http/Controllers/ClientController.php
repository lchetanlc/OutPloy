<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Client::query()
                ->select(['id', 'email'])
                ->orderBy('email')
                ->get()
        );
    }
}
