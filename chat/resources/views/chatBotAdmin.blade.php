@extends('app')

@section('content')
    <div class="container1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Admin Panel</h1>
            <button class="btn btn-success" id="add-new-btn">Add New Question</button>
        </div>

        <form id="filter-form">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->Category }}">{{ $category->Category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="subCat1">SubCat1</label>
                <select id="subCat1" name="subCat1" class="form-control">
                    <option value="">Select Sub-Category 1</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subCat2">SubCat2</label>
                <select id="subCat2" name="subCat2" class="form-control">
                    <option value="">Select Sub-Category 2</option>
                </select>
            </div>
            <div class="filterButton">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Category 1</th>
                    <th>Category 2</th>
                    <th>Questions</th>
                    <th>Answers</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="questions-table">
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->Category }}</td>
                        <td>{{ $question->SubCat1 }}</td>
                        <td>{{ $question->SubCat2 }}</td>
                        <td>{{ $question->Question }}</td>
                        <td>{{ Str::limit($question->Answer, 50, '...') }}</td>
                        <td class="action-btns">
                            <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $question->id }}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $question->id }}">Delete</button>
                            <button class="btn btn-sm btn-info show-btn" data-id="{{ $question->id }}">Show</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Question Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modal-form">
                            <input type="hidden" id="question-id">
                            <div class="form-group">
                                <label for="modal-category">Category</label>
                                <input type="text" id="modal-category" name="category" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="modal-subCat1">SubCat1</label>
                                <input type="text" id="modal-subCat1" name="subCat1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="modal-subCat2">SubCat2</label>
                                <input type="text" id="modal-subCat2" name="subCat2" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="modal-question">Question</label>
                                <input type="text" id="modal-question" name="question" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="modal-answer">Answer</label>
                                <textarea id="modal-answer" rows="5" cols="50" name="answer" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="show-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Question Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Category:</strong> <span id="show-category"></span></p>
                        <p><strong>SubCat1:</strong> <span id="show-subCat1"></span></p>
                        <p><strong>SubCat2:</strong> <span id="show-subCat2"></span></p>
                        <p><strong>Question:</strong> <span id="show-question"></span></p>
                        <p><strong>Answer:</strong> <span id="show-answer"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* Add CSS styles directly within the scripts section */
        .container {
            width: 100%;
            max-width: none;
        }

        .container1 {
            border: 2px solid #1f1d1d;
            padding: 20px;
            border-radius: 10px;
        }

        .action-btns button {
            margin-bottom: 5px;
            width: 70%;
            /* Add space between buttons */
        }

        .filterButton {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
        }

        .modal-dialog {
            /* Add your existing styles here */

            /* Add shadow to the dialog box */
            box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');
            const questionsTable = document.getElementById('questions-table');
            const addNewBtn = document.getElementById('add-new-btn');
            const modal = document.getElementById('modal');
            const modalForm = document.getElementById('modal-form');
            const showModal = document.getElementById('show-modal');
            const closeModal = document.querySelector('.close');

            document.querySelector('#show-modal .close').addEventListener('click', function() {
                showModal.style.display = 'none';
            });

            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(filterForm);
                fetch('{{ route('admin.filter') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        questionsTable.innerHTML = '';
                        data.questions.forEach(question => {
                            questionsTable.innerHTML += `
                        <tr>
                            <td>${question.Category}</td>
                            <td>${question.SubCat1}</td>
                            <td>${question.SubCat2}</td>
                            <td>${question.Question}</td>
                            <td>${question.Answer.length > 50 ? question.Answer.substr(0, 50) + '...' : question.Answer}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="${question.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${question.id}">Delete</button>
                                <button class="btn btn-sm btn-info show-btn" data-id="${question.id}">Show</button>
                            </td>
                        </tr>
                    `;
                        });
                    });
            });

            document.getElementById('category').addEventListener('change', function() {
                const category = this.value;
                fetch('{{ route('getSubCat1Options') }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            category: category
                        }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const subCat1 = document.getElementById('subCat1');
                        subCat1.innerHTML = '<option value="">Select SubCat1</option>';
                        data.options.forEach(option => {
                            subCat1.innerHTML +=
                                `<option value="${option.SubCat1}">${option.SubCat1}</option>`;
                        });
                    });
            });

            document.getElementById('subCat1').addEventListener('change', function() {
                const category = document.getElementById('category').value;
                const subCat1 = this.value;
                fetch('{{ route('getSubCat2Options') }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            category: category,
                            subCat1: subCat1
                        }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const subCat2 = document.getElementById('subCat2');
                        subCat2.innerHTML = '<option value="">Select SubCat2</option>';
                        data.options.forEach(option => {
                            subCat2.innerHTML +=
                                `<option value="${option.SubCat2}">${option.SubCat2}</option>`;
                        });
                    });
            });

            addNewBtn.addEventListener('click', function() {
                modal.style.display = 'block';
                modalForm.reset();
            });

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            modalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(modalForm);
                const id = document.getElementById('question-id').value;
                let url = id ? `/chatBotAdmin/update/${id}` : '/chatBotAdmin/store';
                let method = 'POST';

                fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        modal.style.display = 'none';
                        filterForm.dispatchEvent(new Event('submit'));
                    });
            });

            questionsTable.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    const id = e.target.getAttribute('data-id');
                    fetch(`/questions/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('question-id').value = id;
                            document.getElementById('modal-category').value = data.Category;
                            document.getElementById('modal-subCat1').value = data.SubCat1;
                            document.getElementById('modal-subCat2').value = data.SubCat2;
                            document.getElementById('modal-question').value = data.Question;
                            document.getElementById('modal-answer').value = data.Answer;
                            modal.style.display = 'block';
                        });
                }

                if (e.target.classList.contains('delete-btn')) {
                    const id = e.target.getAttribute('data-id');
                    fetch(`/chatBotAdmin/delete/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            filterForm.dispatchEvent(new Event('submit'));
                        });
                }

                if (e.target.classList.contains('show-btn')) {
                    const id = e.target.getAttribute('data-id');
                    fetch(`/questions/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('show-category').innerText = data.Category;
                            document.getElementById('show-subCat1').innerText = data.SubCat1;
                            document.getElementById('show-subCat2').innerText = data.SubCat2;
                            document.getElementById('show-question').innerText = data.Question;
                            document.getElementById('show-answer').innerText = data.Answer;
                            showModal.style.display = 'block';
                        });
                }
            });
        });
    </script>
@endsection
