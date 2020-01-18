document.addEventListener('DOMContentLoaded', function () {
    let addButton = document.getElementById('add');
    let taskInput = document.getElementById('task-to-add');

    addButton.addEventListener('click', function () {
        let task = taskInput.value;

        if (!testTask(task)) {

            return;
        }

        sendTask(task);
    });

    taskInput.addEventListener('keyup', function (event) {
        if (!testTask(event.target.value)) {
            event.target.classList.add('border', 'border-warning');
            addButton.classList.add('border', 'border-warning', 'btn-outline-warning');
            addButton.classList.remove('btn-outline-primary');
        } else {
            event.target.classList.remove('border', 'border-warning');
            addButton.classList.remove('border', 'border-warning', 'btn-outline-warning');
            addButton.classList.add('btn-outline-primary');
        }
    });


    function testTask(task) {
        return /\w/.test(task);
    }

    function sendTask(task) {
        let formRequest = new FormData();
        formRequest.append('task', task);
        fetch('./addTask', {
            method: 'POST',
            body: formRequest
        });
    }
}, false);