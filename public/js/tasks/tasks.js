document.addEventListener('DOMContentLoaded', function () {
    let wordCharacters = /\w+/;
    let digits = /\d+/;
    let addButton = document.getElementById('add');
    let taskInput = document.getElementById('task-to-add');

    defineListItems();

    addButton.addEventListener('click', function () {
        let task = taskInput.value;

        if (!testWithPattern(task, wordCharacters)) {

            return;
        }

        addTask(task);
    });

    taskInput.addEventListener('keyup', function (event) {
        if (!testWithPattern(event.target.value, wordCharacters)) {
            event.target.classList.add('border', 'border-warning');
            addButton.classList.add('border', 'border-warning', 'btn-outline-warning');
            addButton.classList.remove('btn-outline-primary');
        } else {
            event.target.classList.remove('border', 'border-warning');
            addButton.classList.remove('border', 'border-warning', 'btn-outline-warning');
            addButton.classList.add('btn-outline-primary');
        }
    });

    function testWithPattern(task, pattern) {
        return pattern.test(task);
    }

    function removeTask(id) {
        let formRequest = new FormData();
        formRequest.append('id', id);
        console.log(id);


        fetch('./removeTask', {
            method: 'POST',
            body: formRequest
        }).then((response) => {
            return response.json();
        }).then((json) => {
            listItems.forEach(item => {
                if (item.dataset.id == json.id) {
                    item.remove();
                }
            });
        })
    }

    function addTask(task) {
        let formRequest = new FormData();
        formRequest.append('task', task);
        fetch('./addTask', {
            method: 'POST',
            body: formRequest
        }).then((response) => {
            return response.json();
        }).then((json) => {
            let list = document.querySelector('.list-group');
            let li = document.createElement('li');
            li.textContent = json.task;
            li.classList.add('list-group-item', 'my-2');
            li.setAttribute('data-id', json.id)
            list.prepend(li);
            taskInput.value = '';
            defineListItems();
        });
    }

    function defineListItems() {
        listItems = document.querySelectorAll('li');

        listItems.forEach((listItem) => {
            listItem.addEventListener('click', function (event) {
                let itemId = event.target.dataset.id;

                if (!testWithPattern(itemId, digits)) {

                    return;
                }

                removeTask(itemId);
            });
        })
    }

}, false);