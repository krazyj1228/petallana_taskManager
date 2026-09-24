<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskline | Personal task manager</title>
    <link rel="stylesheet" href="/taskline.css">
    <link rel="stylesheet" href="/taskline-theme.css">
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <a class="brand" href="/tasks"><span class="brand-mark">/</span> TASK MANAGER</a>
            
        </header>

        <section class="intro">
            <div>
                <p class="eyebrow">YOUR DAY, IN MOTION</p>
                <h1>List all the task<br><em>that matters.</em></h1>
            </div>
            
        </section>

        @if (session('success'))
            <div class="notice">{{ session('success') }} <span>✓</span></div>
        @endif

        <section class="workspace">
            <aside class="composer">
                <div class="section-heading">
                    <span class="section-number">01</span>
                    <h2>{{ $editingTask ? 'Edit task' : 'New task' }}</h2>
                </div>
                <form method="POST" action="{{ $editingTask ? '/tasks/'.$editingTask->id : '/tasks' }}">
                    @csrf
                    @if ($editingTask) @method('PUT') @endif
                    <label for="title">Task name</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $editingTask?->title) }}" placeholder="What needs doing?" required autofocus>
                    @error('title') <small class="error">{{ $message }}</small> @enderror

                    <label for="description">Notes <span>(optional)</span></label>
                    <textarea id="description" name="description" rows="4" placeholder="Add a little context...">{{ old('description', $editingTask?->description) }}</textarea>
                    @error('description') <small class="error">{{ $message }}</small> @enderror

                    <label>Status</label>
                    <div class="status-picker">
                        @foreach (['pending' => 'Pending', 'completed' => 'Completed'] as $value => $label)
                            <label class="status-option"><input type="radio" name="status" value="{{ $value }}" @checked(old('status', $editingTask?->status ?? 'pending') === $value)><span>{{ $label }}</span></label>
                        @endforeach
                    </div>
                    @error('status') <small class="error">{{ $message }}</small> @enderror

                    <button class="button button-primary" type="submit">{{ $editingTask ? 'Save changes' : 'Add to list' }} <span>↗</span></button>
                    @if ($editingTask)<a class="cancel" href="/tasks">Cancel editing</a>@endif
                </form>
            </aside>

            <section class="task-list">
                <div class="list-header">
                    <div class="section-heading"><span class="section-number">02</span><h2>Current list</h2></div>
                    <span class="task-count">{{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}</span>
                </div>

                @if ($tasks->isEmpty())
                    <div class="empty-state"><strong>Your list is clear.</strong><span>Add the first task when you are ready to begin.</span></div>
                @else
                    <div class="tasks">
                        @foreach ($tasks as $task)
                            <article class="task {{ $task->status === 'completed' ? 'is-complete' : '' }}">
                                <form method="POST" action="/tasks/{{ $task->id }}/toggle" class="check-form">@csrf @method('PATCH')<button class="check" type="submit" aria-label="Mark {{ $task->status === 'completed' ? 'pending' : 'completed' }}">{{ $task->status === 'completed' ? '✓' : '' }}</button></form>
                                <div class="task-body"><h3>{{ $task->title }}</h3>@if ($task->description)<p>{{ $task->description }}</p>@endif<div class="task-meta"><span class="tag tag-{{ $task->status }}">{{ $task->status }}</span><time>{{ $task->created_at->format('M j, Y') }}</time></div></div>
                                <div class="task-actions"><a href="/tasks/{{ $task->id }}/edit" aria-label="Edit task">✎</a><form method="POST" action="/tasks/{{ $task->id }}">@csrf @method('DELETE')<button type="submit" aria-label="Delete task" onclick="return confirm('Delete this task?')">×</button></form></div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </section>

        <footer><span>FOCUS / FINISH / REPEAT</span><span>BUILT FOR THE NEXT RIGHT THING</span></footer>
    </main>
    <script>
        if (window.location.hostname.endsWith('.app.github.dev') && window.location.port) {
            const publicOrigin = window.location.origin.replace(/:\d+$/, '');
            window.history.replaceState({}, '', publicOrigin + window.location.pathname + window.location.search + window.location.hash);
            document.querySelectorAll('a[href^="/"], form[action^="/"]').forEach((element) => {
                const attribute = element.tagName === 'FORM' ? 'action' : 'href';
                element.setAttribute(attribute, publicOrigin + element.getAttribute(attribute));
            });
        }
    </script>
</body>
</html>t