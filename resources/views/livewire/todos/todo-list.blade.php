<?php

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $task = '';

    public function addTask(): void
    {
        if (trim($this->task) !== '') {
            Todo::create([
                'task' => $this->task,
                'user_id' => Auth::id(),
            ]);

            $this->task = ''; 
        }
    }

    public function toggleComplete(int $id): void
    {
        $todo = Todo::where('id', $id)->where('user_id', Auth::id())->first();
        if ($todo) {
            $todo->completed = !$todo->completed;
            $todo->save();
        }
    }

    public function deleteTask(int $id): void
    {
        Todo::where('id', $id)->where('user_id', Auth::id())->delete();
    }

    public function todos()
    {
        return Todo::where('user_id', Auth::id())->orderByDesc('created_at')->get();
    }
};
?>

<div class="max-w-lg mx-auto mt-10 p-5 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">Todo List</h2>

    <!-- Input Field -->
    <div class="flex space-x-2 mb-4">
        <input type="text" wire:model="task" placeholder="Enter a task"
            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none">
        <button wire:click="addTask" class="bg-blue-500 text-white px-4 py-1 rounded">
            Add
        </button>
    </div>

    <!-- Task List -->
    <ul>
        @foreach($this->todos() as $todo)
            <li class="flex justify-between items-center bg-gray-100 px-4 py-2 rounded mb-2">
                <div class="flex items-center">
                    <input type="checkbox" wire:click="toggleComplete({{ $todo->id }})"
                        {{ $todo->completed ? 'checked' : '' }} class="mr-2">
                    <span class="{{ $todo->completed ? 'line-through text-gray-500' : '' }}">
                        {{ $todo->task }}
                    </span>
                </div>
                <button wire:click="deleteTask({{ $todo->id }})" class="text-red-500 hover:text-red-700">
                    Delete
                </button>
            </li>
        @endforeach
    </ul>
</div>
