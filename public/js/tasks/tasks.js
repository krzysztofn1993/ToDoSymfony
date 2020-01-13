document.addEventListener('DOMContentLoaded', function () {
    let addButton = document.getElementById('add');
    let taskInput = document.getElementById('task-to-add');

    addButton.addEventListener('click', function () {
        let task = taskInput.value;

        if (!testTask(task)) {

            return;
        }

        // fetch('/addTask', {
        //     method: 'GET',
        //     body: 
        // });
    });

    taskInput.addEventListener('keydown', function (eventTarget) {
        eventTarget.clas

        if (!testTask(eventTarget.value)) {

        }
    });

    function testTask(task) {
        return /\w/.test(task);
    }




}, false);