
<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">
                Personal task board
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                My Tasks
            </h2>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-9rem)] bg-slate-950 px-6 py-10 text-white">
        <div class="mx-auto max-w-4xl">
            <form method="POST" action="{{ route('tasks.store') }}" class="rounded-lg border border-white/10 bg-white/10 p-6 shadow-2xl">
                @csrf

                <label for="title" class="block text-sm font-semibold text-emerald-300">
                    New task
                </label>

                <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title') }}"
                        placeholder="What do you need to finish?"
                        class="min-h-12 flex-1 rounded-md border-white/10 bg-white px-4 text-slate-950 shadow-sm focus:border-emerald-400 focus:ring-emerald-400"
                    >

                    <button type="submit" class="rounded-md bg-emerald-400 px-5 py-3 font-semibold text-slate-950">
                        Add task
                    </button>
                </div>

                @error('title')
                <p class="mt-3 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </form>

            <div class="mt-8 space-y-3">
                @forelse ($tasks as $task)
                    <div class="flex flex-col gap-3 rounded-lg border border-white/10 bg-white p-4 text-slate-950 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p @class([
                                'font-semibold',
                                'text-slate-400 line-through' => $task->is_completed,
                            ])>
                                {{ $task->title }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $task->is_completed ? 'Completed' : 'Open' }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="is_completed" value="{{ $task->is_completed ? 0 : 1 }}">

                                <button type="submit" class="rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700">
                                    {{ $task->is_completed ? 'Reopen' : 'Complete' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="rounded-md bg-slate-950 px-3 py-2 text-sm font-medium text-white">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg border border-dashed border-white/20 p-8 text-center text-slate-300">
                        No tasks yet. Add your first one above.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
