<form method="POST" action="{{ route('task.share', $task->id) }}" id="share-form">
    @csrf
{{--@dd($errors)--}}
    <div id="users-container">
        @foreach ($users as $index => $user)
            <div class="user-entry" style="margin-bottom: 10px;">
                <label>
                    <input type="checkbox" class="user-checkbox">
                    {{ $user->name }} ({{ $user->email }})
                </label>

                <input type="hidden" class="user-id" value="{{ $user->id }}">

                <select class="user-role">
                    <option value="editor">Editor</option>
                    <option value="observer">Observer</option>
                </select>
            </div>
        @endforeach
    </div>

    {{-- Контейнер, в который JS вставит input-ы --}}
    <div id="generated-inputs"></div>

    <button type="submit">Share</button>
</form>

<script>
    const form = document.getElementById('share-form');
    const generated = document.getElementById('generated-inputs');

    form.addEventListener('submit', function (e) {
        generated.innerHTML = ''; // очищаем старое

        document.querySelectorAll('.user-entry').forEach((entry, i) => {
            const checkbox = entry.querySelector('.user-checkbox');
            if (checkbox.checked) {
                const id = entry.querySelector('.user-id').value;
                const role = entry.querySelector('.user-role').value;

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = `users[${i}][id]`;
                idInput.value = id;

                const roleInput = document.createElement('input');
                roleInput.type = 'hidden';
                roleInput.name = `users[${i}][role]`;
                roleInput.value = role;

                generated.appendChild(idInput);
                generated.appendChild(roleInput);
            }
        });
    });
</script>
