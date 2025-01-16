<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Category;
use App\Models\Label;
use App\Models\Task;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        $pagination = [
            'current_page' => $tasks->currentPage(),
            'total' => $tasks->total(),
            'per_page' => $tasks->perPage(),
            'last_page' => $tasks->lastPage(),
        ];

        $tasks = TaskResource::collection($tasks)->resolve();
        $labels = Label::whereHas('tasks', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return inertia('Tasks/Index', compact('pagination', 'labels', 'tasks'));
    }
    public function create() {

        $categories = Category::where('user_id', auth()->id())->get();

        $labels = Label::where('user_id', auth()->id())->get();
        return inertia('Tasks/Create', compact('categories', 'labels'));
    }

    public function store(StoreRequest $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $data = $request->validated();
        if (isset($data['selectedLabels'])) {
            $labelsId = array_map(fn($l) => $l['id'], $data['selectedLabels']);
        } else {
            $labelsId = [];
        }
        unset($data['selectedLabels']);

        $data['user_id'] = auth()->id();
       $task = Task::create($data) ;
        if (!empty($labelsId)) {
            $validLabelsId = Label::whereIn('id', $labelsId)
                ->where('user_id', auth()->id())
                ->pluck('id')->toArray();
            $task->labels()->attach($validLabelsId);
    }
        return redirect()->route('tasks.index');

    }

    public function show(Task $task)
    {
        $task = TaskResource::make($task)->resolve();
        return inertia('Tasks/Show', compact('task'));
    }

    public function edit(Task $task)
    {

        $task = Task::with('category', 'labels')->findOrFail($task->id);
        $categories = Category::where('user_id', auth()->id())->get();
        $labels = Label::where('user_id', auth()->id())->get();
        if ($task['category_id'] == null) {
            $task['category_id'] = '';

        }
        return inertia('Tasks/Edit', compact('task', 'categories', 'labels'));

    }

    public function update(UpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        if (isset($data['selectedLabels'])) {
            $labelsId = array_map(fn($l) => $l['id'], $data['selectedLabels']);
        } else {
            $labelsId = [];
        }
        unset($data['selectedLabels']);
        $task->update($data);
        if (!empty($labelsId)) {
            $validLabelsId = Label::whereIn('id', $labelsId)
                ->where('user_id', auth()->id())
                ->pluck('id')->toArray();

            $task->labels()->sync($validLabelsId);
        }
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }


}
