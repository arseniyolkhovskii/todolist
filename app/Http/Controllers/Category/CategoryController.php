<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\Category\CategoryIndexResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Category;
use App\Models\Task;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $pagination = [
            'current_page' => $categories->currentPage(),
            'total' => $categories->total(),
            'per_page' => $categories->perPage(),
            'last_page' => $categories->lastPage(),
        ];

        $categories = CategoryIndexResource::collection($categories)->resolve();
        return inertia('Categories/Index', compact('categories', 'pagination'));
    }
    public function create() {
        return inertia('Categories/Create');
    }

    public function store(StoreRequest $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Category::create($data) ;
        return redirect()->route('categories.index');
    }
    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('categories.index');
    }
    public function showTasks($id)
    {
        $category = Category::findOrFail($id);
        $tasks = $category->tasks()->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(5);

        $categoryTasks = CategoryResource::make($category)->resolve();

        $tasksResource = TaskResource::collection($tasks)->toArray(request());;
        $categoryTasks = array_merge($categoryTasks, [
            'tasks' => $tasksResource,
            'current_page' => $tasks->currentPage(),
            'total' => $tasks->total(),
            'per_page' => $tasks->perPage(),
            'last_page' => $tasks->lastPage(),
        ]);
        $id = (int) $id;
        return inertia('Categories/ShowTasks', compact('categoryTasks','id'));
    }

    public function edit(Category $category)
    {
        return inertia('Categories/Edit', compact('category'));
    }
    public function update(UpdateRequest $request, Category $category)
    {

        $data = $request->validated();
        $category->update($data);
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {

        $category = CategoryResource::make($category)->resolve();
        return inertia('Categories/Show', compact('category'));
    }
}
