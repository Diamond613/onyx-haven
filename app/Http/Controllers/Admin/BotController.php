<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminBotService;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $admin = auth()->user();
        $bot = new AdminBotService($admin->id, $admin->name);
        $result = $bot->handle($request->input('message'));

        return response()->json([
            'answer' => $result['reply'],
            'replies' => $result['quickReplies'],
            'links' => $result['links'],
            'refreshStats' => $result['refreshStats'] ?? false,
        ]);
    }
}