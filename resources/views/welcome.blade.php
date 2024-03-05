<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Todos</title>

    @vite('resources/css/app.css')
</head>
<body class="px-6 py-10">
<div>
    <div class="mb-10">
        <h2 class="text-3xl font-bold underline mb-2">Stats</h2>
        @if(\App\Models\Todo::overToday()->allaria()->sum('points') >= 4 && \App\Models\Todo::overToday()->emprendimiento()->sum('points') >= 1 && \App\Models\Todo::overToday()->ejercicio()->sum('points') >= 1)
            <p class="w-[210px] text-green-100 bg-green-600 rounded-xl px-6 py-4">Objetivos alcanzados!</p>
        @else
            <p class="w-[150px] text-yellow-100 bg-yellow-600 rounded-xl px-6 py-4">En proceso...</p>
        @endif

        <table>
            <tr>
                <th>Tag</th>
                <th>Objetivo</th>
                <th>Actual</th>
            </tr>
            <tr>
                <td>Allaria</td>
                <td>4</td>
                <td>{{ \App\Models\Todo::overToday()->allaria()->sum('points') }}</td>
            </tr>
            <tr>
                <td>Emprendimiento</td>
                <td>1</td>
                <td>{{ \App\Models\Todo::overToday()->emprendimiento()->sum('points') }}</td>
            </tr>
            <tr>
                <td>Ejercicio</td>
                <td>1</td>
                <td>{{ \App\Models\Todo::overToday()->ejercicio()->sum('points') }}</td>
            </tr>
        </table>

        <div>
            <p>2 puntos compran una partida de ajedrez</p>
            <p>1 punto compra estudiar ajedrez por media hora</p>
            <p>2 puntos compran 30 minutos de duolingo</p>
        </div>

    </div>

    <h2 class="text-3xl font-bold underline mb-10">
        Todos!
    </h2>

    <div class="mb-10">
        <div class="flex gap-x-40 mb-6">
            <p class="font-light">Created at</p>
            <p class="font-light">Name</p>
            <p class="font-light">Points</p>
            <p class="font-light">Tag</p>
            <p class="font-light">Subtag</p>
            <p class="font-light">Highlight</p>
            <p class="font-light">State</p>
            <p class="font-light">Description</p>
            <p class="font-light">Parent id</p>
            <p class="font-light">Done at</p>
        </div>
        @foreach($todos as $todo)
            <form method="POST" action="{{ route('update.todos', $todo->id) }}" class="mb-2 flex gap-x-6">
                @csrf
                @method('PATCH')
                <input value="{{ $todo->created_at->diffForHumans() }}" placeholder="name" type="text" name="name"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <input value="{{ $todo->name }}" placeholder="name" type="text" name="name"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <input value="{{ $todo->points }}" placeholder="points" type="number" name="points"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <select name="tag"
                        class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                    <option {{ $todo->tag()->first()->name === 'Allaria' ? 'selected' : '' }} value="Allaria">Allaria
                    </option>
                    <option
                        {{ $todo->tag()->first()->name === 'Emprendimiento' ? 'selected' : '' }} value="Emprendimiento">
                        Emprendimiento
                    </option>
                    <option {{ $todo->tag()->first()->name === 'Ejercicio' ? 'selected' : '' }} value="Ejercicio">
                        Ejercicio
                    </option>
                </select>
                <select name="subtag"
                        class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                    <option {{ $todo->subtag()->first()->name == 'Code' ? 'selected' : '' }} value="Code">Code</option>
                    <option {{ $todo->subtag()->first()->name == 'Research' ? 'selected' : '' }}  value="Research">
                        Research
                    </option>
                    <option {{ $todo->subtag()->first()->name == 'Test' ? 'selected' : '' }}  value="Test">Test</option>
                    <option {{ $todo->subtag()->first()->name == 'Bicicleta' ? 'selected' : '' }} value="Bicicleta">
                        Bicicleta
                    </option>
                    <option {{ $todo->subtag()->first()->name == 'Crossfit' ? 'selected' : '' }}  value="Crossfit">
                        Crossfit
                    </option>
                </select>
                <input value="{{ $todo->highlight }}" placeholder="highlight" type="text" name="highlight"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <select name="state"
                        class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                    <option {{ $todo->state === 'to-do' ? 'selected' : '' }} value="to-do">To do
                    </option>
                    <option
                        {{ $todo->state === 'doing' ? 'selected' : '' }} value="doing">
                        Doing
                    </option>
                    <option {{ $todo->state === 'done' ? 'selected' : '' }} value="Done">
                        done
                    </option>
                </select>
                <input value="{{ $todo->description }}" placeholder="description" type="text" name="description"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <input value="{{ $todo->parent_id }}" placeholder="parent id" type="text" name="parent_id"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
                <input value="{{ $todo->done_at }}" placeholder="done at" type="text" name="done_at"
                       class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">

                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-xl mt-4">
                    Edit
                </button>
            </form>
        @endforeach
    </div>
    <h2 class="text-3xl font-bold underline mb-10">
        Crear
    </h2>

    <form method="post" action="{{ route('create.todos') }}" class="flex gap-x-6">
        @csrf
        @method('POST')
        <input placeholder="name" type="text" name="name"
               class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
        <input placeholder="points" type="number" name="points"
               class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
        <select name="tag"
                class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
            <option value="Allaria">Allaria</option>
            <option value="Emprendimiento">Emprendimiento</option>
            <option value="Ejercicio">Ejercicio</option>
        </select>
        <select name="subtag"
                class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
            <option value="Code">Code</option>
            <option value="Research">Research</option>
            <option value="Test">Test</option>
            <option value="Bicicleta">Bicicleta</option>
            <option value="Crossfit">Crossfit</option>
        </select>
        <input placeholder="highlight" type="text" name="highlight"
               class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
        <input placeholder="description" type="text" name="description"
               class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
        <input placeholder="parent id" type="text" name="parent_id"
               class="border-gray-200 px-4 focus:px-6 rounded-xl border transition transform duration-200 ease-in-out">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-xl">
            Create
        </button>
    </form>

</div>
</body>
</html>
