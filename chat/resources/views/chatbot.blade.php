<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

</head>

<body>


    <div class="container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="{{ asset('circled-user-female.png') }}" alt="">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">ACPC Chatbot</h4>
                        <p class="chatbox__description--header">Hi, How can I help you?</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div id="chat"></div>
                    <div id="chat2"></div>
                </div>
                <div class="chatbox__footer">
                </div>
            </div>
            <div class="chatbox__button" style="cursor:pointer;">
               

                <?xml version="1.0" encoding="utf-8"?>
                <svg width="70" height="70" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                   
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M14.6522 2.71772C12.9188 2.22247 11.0814 2.22247 9.34802 2.71772L9.22162 2.75383C6.09319 3.64767 3.64777 6.09309 2.75393 9.22152C2.23256 11.0463 2.27471 12.9861 2.87486 14.7865L3.42237 16.4291C3.44651 16.5015 3.4495 16.5793 3.43098 16.6534L2.52996 20.2575C2.44476 20.5982 2.54461 20.9587 2.79299 21.2071C3.04137 21.4555 3.40186 21.5553 3.74264 21.4701L7.34674 20.5691C7.42079 20.5506 7.49859 20.5536 7.57101 20.5777L9.21355 21.1252C11.014 21.7254 12.9538 21.7675 14.7786 21.2462C17.907 20.3523 20.3524 17.9069 21.2463 14.7785L21.2824 14.6521C21.7776 12.9187 21.7776 11.0813 21.2824 9.34792C20.3661 6.14088 17.8592 3.63402 14.6522 2.71772ZM9.89746 4.64077C11.2717 4.24812 12.7285 4.24812 14.1027 4.64077C16.6454 5.36723 18.6329 7.35474 19.3593 9.89736C19.752 11.2716 19.752 12.7284 19.3593 14.1026L19.3232 14.229C18.6192 16.6931 16.6932 18.6191 14.2291 19.3231C12.7919 19.7338 11.2641 19.7006 9.84601 19.2279L8.98347 18.9404C7.89526 18.3048 7.20374 17.8211 6.71829 17.3855L6.71692 17.3843C6.68118 17.3522 6.64655 17.3204 6.61298 17.2888C6.56704 17.2456 6.52305 17.2028 6.48081 17.1602C5.98829 16.6644 5.73426 16.21 5.40919 15.6284C5.30367 15.4396 5.19066 15.2375 5.05957 15.0161L4.77222 14.1541C4.29953 12.736 4.26634 11.2082 4.67698 9.77096C5.38099 7.30695 7.30705 5.38089 9.77107 4.67688L9.89746 4.64077Z"
                        fill="#152C70" />
                    <path
                        d="M7.5 13.5C8.32843 13.5 9 12.8284 9 12C9 11.1716 8.32843 10.5 7.5 10.5C6.67157 10.5 6 11.1716 6 12C6 12.8284 6.67157 13.5 7.5 13.5Z"
                        fill="#9c1de7" />
                    <path
                        d="M13.5 12C13.5 12.8284 12.8284 13.5 12 13.5C11.1716 13.5 10.5 12.8284 10.5 12C10.5 11.1716 11.1716 10.5 12 10.5C12.8284 10.5 13.5 11.1716 13.5 12Z"
                        fill="#9c1de7" />
                    <path
                        d="M16.5 13.5C17.3284 13.5 18 12.8284 18 12C18 11.1716 17.3284 10.5 16.5 10.5C15.6716 10.5 15 11.1716 15 12C15 12.8284 15.6716 13.5 16.5 13.5Z"
                        fill="#9c1de7" />
                    
                </svg>

                <script src="{{ asset('js/chatbot.js') }}"></script>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('body').on('click', '.category-btn', function() {
                var category = $(this).data('category');
                loadSubCat1(category);
            });

            $('body').on('click', '.subCat1-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                loadSubCat2(category, subCat1);
            });

            $('body').on('click', '.subCat2-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                loadQuestions(category, subCat1, subCat2);
            });

            $('body').on('click', '.question-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                var question = $(this).data('question');
                getAnswer(category, subCat1, subCat2, question);
            });

            // Back button handlers
            $('body').on('click', '#back-to-categories', function() {
                loadCategories();
            });

            $('body').on('click', '#back-to-subCat1', function() {
                var category = $(this).data('category');
                loadSubCat1(category);
            });

            $('body').on('click', '#back-to-subCat2', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                loadSubCat2(category, subCat1);
            });

            $('body').on('click', '#back-to-questions', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                loadQuestions(category, subCat1, subCat2);
            });

            $('body').on('click', '#home', function() {
                $('#chat2').html('');
                loadCategories();
            });

            loadCategories();
        });

        function loadCategories() {
            $.ajax({
                url: '/',
                type: 'GET',
                success: function(response) {
                    var categoriesHtml =
                        '@foreach ($categories as $category) <button class="category-btn" id="chat-btn" data-category="{{ $category->Category }}">{{ $category->Category }}</button> @endforeach';
                    $('#chat').html(categoriesHtml);
                    const para = document.createElement("p");
                    const node = document.createTextNode('Please select a category.');
                    para.style.cssText =
                        "color: black; margin-bottom: 10px; padding: 10px; background-color: #E0E0E0; border-radius: 10px;";
                    para.appendChild(node);
                    $('#chat2').append(para);
                }
            });
        }

        function loadSubCat1(category) {
            $.ajax({
                url: '/getSubCat1Options',
                type: 'GET',
                data: {
                    category: category
                },
                success: function(response) {
                    var subCat1Html = "";
                    response.options.forEach(function(option) {
                        subCat1Html += '<button class="subCat1-btn" id="chat-btn" data-category="' +
                            category +
                            '" data-subcat1="' + option.SubCat1 + '">' + option.SubCat1 + '</button>';
                    });
                    subCat1Html +=
                        '<button id="back-to-categories" class="chat-btn">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(subCat1Html);


                    const para = document.createElement("p");
                    const node = document.createTextNode(category);
                    para.style.cssText =
                        "color: black; margin-bottom: 10px; padding: 10px; background-color: #E0E0E0; border-radius: 10px;";
                    para.appendChild(node);
                    $('#chat2').append(para);
                }
            });
        }

        function loadSubCat2(category, subCat1) {
            $.ajax({
                url: '/getSubCat2Options',
                type: 'GET',
                data: {
                    category: category,
                    subCat1: subCat1
                },
                success: function(response) {
                    var subCat2Html = "";
                    response.options.forEach(function(option) {
                        subCat2Html += '<button class="subCat2-btn" id="chat-btn" data-category="' +
                            category +
                            '" data-subcat1="' + subCat1 + '" data-subcat2="' + option.SubCat2 + '">' +
                            option.SubCat2 + '</button>';
                    });
                    subCat2Html += '<button id="back-to-subCat1" class="chat-btn" data-category="' +
                        category +
                        '">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(subCat2Html);

                    const para = document.createElement("p");
                    const node = document.createTextNode(subCat1);
                    para.style.cssText =
                        "color: black; margin-bottom: 10px; padding: 10px; background-color: #E0E0E0; border-radius: 10px;";
                    para.appendChild(node);
                    $('#chat2').append(para);
                }
            });
        }

        function loadQuestions(category, subCat1, subCat2) {
            $.ajax({
                url: '/getQuestions',
                type: 'GET',
                data: {
                    category: category,
                    subCat1: subCat1,
                    subCat2: subCat2
                },
                success: function(response) {
                    var questionsHtml = "";
                    response.questions.forEach(function(question) {
                        questionsHtml += '<button class="question-btn" id="chat-btn" data-category="' +
                            category +
                            '" data-subcat1="' + subCat1 + '" data-subcat2="' + subCat2 +
                            '" data-question="' +
                            question
                            .Question + '">' + question.Question + '</button>';
                    });
                    questionsHtml += '<button id="back-to-subCat2" class="chat-btn" data-category="' +
                        category +
                        '" data-subcat1="' + subCat1 +
                        '">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(questionsHtml);

                    const para = document.createElement("p");
                    const node = document.createTextNode(subCat2);
                    para.style.cssText =
                        "color: black; margin-bottom: 10px; padding: 10px; background-color: #E0E0E0; border-radius: 10px;";
                    para.appendChild(node);
                    $('#chat2').append(para);
                }
            });
        }

        function getAnswer(category, subCat1, subCat2, question) {
            $.ajax({
                url: '/getAnswer',
                type: 'GET',
                data: {
                    category: category,
                    subCat1: subCat1,
                    subCat2: subCat2,
                    question: question
                },
                success: function(response) {
                    if (response.answer) {
                        var answerHtml = "";
                        answerHtml +=
                            '<p style="color:black; margin-bottom: 20px; margin-top: 10px; font-weight: bolder; word-wrap: break-word;">' +
                            response.answer + '</p>';
                    } else {
                        answerHtml += '<p>Error: No answer found for the selected question</p>';
                    }
                    answerHtml +=
                        '<button id="back-to-questions" class="chat-btn" data-category="' + category +
                        '" data-subcat1="' + subCat1 + '" data-subcat2="' + subCat2 +
                        '">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(answerHtml);
                    const para = document.createElement("p");
                    const node = document.createTextNode(question);
                    para.style.cssText =
                        "color: black; margin-bottom: 10px; padding: 10px; background-color: #E0E0E0; border-radius: 10px;";
                    para.appendChild(node);
                    $('#chat2').append(para);

                }
            });
        }
    </script>

</body>

</html>
