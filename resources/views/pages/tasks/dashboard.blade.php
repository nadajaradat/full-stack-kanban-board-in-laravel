@extends('layout.app')

@section('title', '| Dashboard')

@section('content')
    <div class="container mt-3">
        <div class="row" style="min-height: 80vh;">
            @include('components.task-section', ['status' => 'To Do', 'tasks' => $tasks])
            <div class="col-lg-1"></div>
            @include('components.task-section', ['status' => 'In Progress', 'tasks' => $tasks])
            <div class="col-lg-1"></div>
            @include('components.task-section', ['status' => 'Completed', 'tasks' => $tasks])
        </div>
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', async function () {

        let updating = false; // Flag to prevent multiple updates

        const draggables = document.querySelectorAll('.task');
        const containers = document.querySelectorAll('.section');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });


containers.forEach(container => {
    container.addEventListener('dragover', async e => {
        e.preventDefault();

        if (updating) return;
        updating = true;

        const draggable = document.querySelector('.dragging');
        const afterElement = getDragAfterElement(container, e.clientY);

        if (afterElement == null) {
            container.appendChild(draggable);
        } else {
            container.insertBefore(draggable, afterElement);
        }

        const taskId = draggable.dataset.taskId;
        const newStatus = container.dataset.status;

        const position = Array.from(container.children).indexOf(draggable);

        console.log("Task ID: ", taskId);
        console.log("New Status: ", newStatus);
        console.log("Position: ", position);

        try {
            const response = await fetch(`/tasks/${taskId}/update-value/${newStatus}/${position}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            const data = await response.json();
            console.log(data);
        } catch (error) {
            console.error('Error:', error);
        } finally {
            updating = false;
        }
    });
});

// ... Existing code ...


        const getDragAfterElement = (container, y) => {
            const draggableElements = [...container.querySelectorAll('.task:not(.dragging)')];
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        };
    });
</script>
@endsection

