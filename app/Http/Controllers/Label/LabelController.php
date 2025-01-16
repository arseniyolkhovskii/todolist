<?php

namespace App\Http\Controllers\Label;

use App\Http\Controllers\Controller;
use App\Http\Requests\Label\StoreRequest;
use App\Http\Requests\Label\UpdateRequest;
use App\Http\Resources\Label\LabelIndexResource;
use App\Http\Resources\Label\LabelResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Label;


class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        $pagination = [
            'current_page' => $labels->currentPage(),
            'total' => $labels->total(),
            'per_page' => $labels->perPage(),
            'last_page' => $labels->lastPage(),
        ];
        $labels = LabelIndexResource::collection($labels)->resolve();
        return inertia('Label/Index', compact('labels', 'pagination'));
    }

    public function create()
    {

        return inertia('Label/Create');
    }

    public function store(StoreRequest $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Label::create($data);
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        $label->delete();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return inertia('Label/Edit', compact('label'));
    }

    public function update(UpdateRequest $request, Label $label)
    {
        $data = $request->validated();
        $label->update($data);
        return redirect()->route('labels.index');
    }

    public function showTasks($id)
    {

        $label = Label::findOrFail($id);
        $tasks = $label->tasks()->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(4);

        $tasksResource = TaskResource::collection($tasks)->toArray(request());;

        $labelTasks = LabelResource::make($label)->resolve();
        $labelTasks = array_merge($labelTasks, [
            'tasks' => $tasksResource,
            'current_page' => $tasks->currentPage(),
            'total' => $tasks->total(),
            'per_page' => $tasks->perPage(),
            'last_page' => $tasks->lastPage(),
        ]);
        $id = (int)$id;
        return inertia('Label/ShowTasks', compact('labelTasks', 'id'));
    }

}
