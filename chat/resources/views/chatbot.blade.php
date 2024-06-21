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
                        <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-5--v1.png"
                            alt="image">
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
            <div class="chatbox__button" style="cursor:pointer">
                <svg id="svg" width="70" height="50"
                    style="border: black 4px solid; border-radius: 100%; padding: 7px;" viewBox="0 0 36 29"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M28.2857 10.5714C28.2857 4.88616 21.9576 0.285714 14.1429 0.285714C6.32813 0.285714 0 4.88616 0 10.5714C0 13.8259 2.08929 16.7388 5.34375 18.6272C4.66071 20.2946 3.77679 21.0781 2.9933 21.9621C2.77232 22.2232 2.51116 22.4643 2.59152 22.846C2.65179 23.1875 2.93304 23.4286 3.23438 23.4286C3.25446 23.4286 3.27455 23.4286 3.29464 23.4286C3.89732 23.3482 4.47991 23.2478 5.02232 23.1071C7.05134 22.5848 8.93973 21.721 10.6071 20.5357C11.7321 20.7366 12.9174 20.8571 14.1429 20.8571C21.9576 20.8571 28.2857 16.2567 28.2857 10.5714ZM36 15.7143C36 12.3594 33.7902 9.38616 30.3951 7.51786C30.6964 8.50223 30.8571 9.52679 30.8571 10.5714C30.8571 14.1674 29.0089 17.4821 25.654 19.933C22.5402 22.183 18.4621 23.4286 14.1429 23.4286C13.5603 23.4286 12.9576 23.3884 12.375 23.3482C14.8862 24.9955 18.221 26 21.8571 26C23.0826 26 24.2679 25.8795 25.3929 25.6786C27.0603 26.8638 28.9487 27.7277 30.9777 28.25C31.5201 28.3906 32.1027 28.4911 32.7054 28.5714C33.0268 28.6116 33.3281 28.3504 33.4085 27.9888C33.4888 27.6071 33.2277 27.3661 33.0067 27.1049C32.2232 26.221 31.3393 25.4375 30.6563 23.7701C33.9107 21.8817 36 18.9888 36 15.7143Z"
                        fill="#581B98" />
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

            // Load initial categories
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
                    subCat1Html += '<button id="back-to-categories" class="chat-btn">Back</button><button id="home" class="chat-btn">Home</button>';
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
                        '" data-subcat1="' + subCat1 + '">Back</button><button id="home" class="chat-btn">Home</button>';
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


                        console.log(response.answer);
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
