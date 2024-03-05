<?php

namespace App\Http\Controllers;

use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use App\Services\CreateTodoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function index()
    {
        # 2 puntos compran una partida de ajedrez
        # 1 compra estudio de ajedrez
        # 1 compra 30 mins de duolingo.

        # Puntos objetivo
        # Puntos mes


        $todos = Todo::get();

        return view('welcome', [
            'todos' => $todos
        ]);
    }

    /**
     * Ver posibles plantillas en App\Services\Plantillas
     *
     * @param Request $request
     * @param $plantilla
     * @param CreateTodoService $createTodoService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $plantilla, CreateTodoService $createTodoService)
    {
        $resolved = $createTodoService->resolve($plantilla);

        if ($resolved['error']) {
            return redirect()->back();
        }

        $createTodoService->execute();

        return redirect()->back();
    }

    public function update(Request $request, Todo $todo)
    {
        if ($request->state == 'done' && $todo->done_at == null) {
            $done_at = Carbon::now();
            $todo->update([
                'done_at' => $done_at
            ]);
        }

        $todo->update([
            'name' => $request->name,
            'description' => $request->description,
            'tag_id' => Tag::where('name', $request->tag)->first()->id,
            'sub_tag_id' => SubTag::where('name', $request->subtag)->first()->id,
            'points' => $request->points,
            'state' => $request->state,
            'highlight' => $request->highlight,
            'parent_id' => $request->parent,
        ]);

        return redirect()->back();
    }
}
