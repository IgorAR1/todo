<?php

namespace App\Http\Middleware;


use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $task = $request->route('task');
        $user = $request->user();

//        if (!$task instanceof Task){
//            $task = Task::query()->findOrFail($task);
//        }

        if ($task && $user && $user->isOwner($task)) {
            return $next($request);
        }

        abort(403);
    }
}
