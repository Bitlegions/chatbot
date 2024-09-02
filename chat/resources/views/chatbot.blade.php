<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

</head>

<body {{-- style="background-image: url('https://cdn.pixabay.com/photo/2024/05/26/10/15/bird-8788491_1280.jpg'); height: 10000px"> --}} <div class="container">
    <div class="chatbox">
        <div class="chatbox__support">
            <div class="chatbox__header">
                <div class="chatbox__image--header">
                    <img width="70" height="70" viewBox="0 0 24 24" src="{{ asset('AskAlly-jpg.jpg') }}"
                        alt="" style="border: 4px solid black; border-radius: 50%;">

                </div>
                <div class="chatbox__content--header">
                    <h4 class="chatbox__heading--header">Ask Ally</h4>
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
            <img width="100" height="100" viewBox="0 0 24 24" src="{{ asset('AskAlly-gif.gif') }}" alt=""
                style="border: 4px solid black; border-radius: 50%;">
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
                    const node = document.createTextNode('Please select.');
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
