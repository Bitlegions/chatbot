<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Nunito', sans-serif;
            font-weight: 400;
            font-size: 100%;
            background: #F1F1F1;
        }

        *,
        html {
            --primaryGradient: linear-gradient(93.12deg, #581B98 0.52%, #9C1DE7 100%);
            --secondaryGradient: linear-gradient(268.91deg, #581B98 -2.14%, #9C1DE7 99.69%);
            --primaryBoxShadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            --secondaryBoxShadow: 0px -10px 15px rgba(0, 0, 0, 0.1);
            --primary: #581B98;
        }

        .chatbox {
            position: absolute;
            bottom: 30px;
            right: 30px;
        }

        /* CONTENT IS CLOSE */
        .chatbox__support {
            display: flex;
            flex-direction: column;
            background: #eee;
            width: 1000px;
            height: 1050px;
            z-index: -123456;
            opacity: 0;
            transition: all .5s ease-in-out;
        }

        /* CONTENT ISOPEN */
        .chatbox--active {
            transform: translateY(-40px);
            z-index: 123456;
            opacity: 1;

        }

        /* BUTTON */
        .chatbox__button {
            text-align: right;
        }

        .send__button {
            padding: 6px;
            background: transparent;
            border: none;
            outline: none;
            cursor: pointer;
        }


        /* HEADER */
        .chatbox__header {
            position: sticky;
            top: 0;
            /* background: orange; */
        }

        /* MESSAGES */
        .chatbox__messages {
            margin-top: auto;
            display: flex;
            overflow-y: scroll;
            flex-direction: column-reverse;
        }

        .chatbox__messages::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        .chatbox__messages::-webkit-scrollbar:vertical {
            width: 11px;
        }

        .chatbox__messages::-webkit-scrollbar:horizontal {
            height: 11px;
        }

        .chatbox__messages::-webkit-scrollbar-thumb {
            border-radius: 8px;
            border: 2px solid white;
            /* should match background, can't be transparent */
            background-color: rgba(0, 0, 0, .5);
        }

        .messages__item {
            background: orange;
            max-width: 60.6%;
            width: fit-content;
        }

        .messages__item--operator {
            margin-left: auto;
        }

        .messages__item--visitor {
            margin-right: auto;
        }

        /* FOOTER */
        .chatbox__footer {
            position: sticky;
            bottom: 0;
        }

        .chatbox__support {
            background: #f9f9f9;
            height: 600px;
            width: 450px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        /* HEADER */
        .chatbox__header {
            background: var(--primaryGradient);
            display: flex;
            flex-direction: row;
            align-items: center;

            padding: 10px 20px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: var(--primaryBoxShadow);
        }

        .chatbox__image--header {
            margin-right: 10px;
        }

        .chatbox__heading--header {
            font-size: 1.2rem;
            color: white;
        }

        .chatbox__description--header {
            font-size: .9rem;
            color: white;
        }

        /* Messages */
        .chatbox__messages {
            padding: 0 20px;
        }

        .messages__item {
            margin-top: 10px;
            background: #E0E0E0;
            padding: 8px 12px;
            max-width: 70%;
        }

        .messages__item--visitor,
        .messages__item--typing {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        #chat {
            /* border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px; */
            background: #E0E0E0;
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 90%;
        }

        #chat2 {
            /* border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px; */
            margin-top: 40px;
            background: #E0E0E0;
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 90%;
            margin-bottom: 3%;
            text-align: center;
            font-weight: bolder;
        }

        #chat-btn {
            font-size: medium;
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            width: 95%;
        }

        .chat-btn {
            font-size: medium;
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            width: 95%
        }

        .messages__item--operator {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
            background: var(--primary);
            color: white;
        }

        /* FOOTER */
        .chatbox__footer {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 10px 10px;
            background: var(--secondaryGradient);
            box-shadow: var(--secondaryBoxShadow);
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            margin-top: 20px;
        }

        .chatbox__footer input {
            width: 80%;
            border: none;
            padding: 10px 10px;
            border-radius: 30px;
            text-align: left;
        }

        .chatbox__send--footer {
            color: white;
        }

        .chatbox__button button,
        .chatbox__button button:focus,
        .chatbox__button button:visited {
            padding: 10px;
            background: white;
            border: none;
            outline: none;
            border-top-left-radius: 50px;
            border-top-right-radius: 50px;
            border-bottom-left-radius: 50px;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        @media screen and (max-width: 768px) {

            body {
                font-family: 'Nunito', sans-serif;
                font-weight: 300;
                font-size: 100%;
                background: #F1F1F1;
            }

            #chat {
                width: 90%;
            }

            #chat-btn {
                padding: 10px;
                border-radius: 10px;
                margin: 2px;
                width: 95%
            }

            .chatbox {
                bottom: 20px;
                right: 20px;
            }

            .chatbox__support {
                width: 65vh;
                height: 80vh;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }

            .chatbox__header,
            .chatbox__footer {
                /* flex-direction: column; */
                padding: 10px;
            }

            .chatbox__heading--header {
                font-size: 1rem;
            }

            .chatbox__description--header {
                font-size: 0.8rem;
            }

            .chatbox__footer input {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                font-size: 85%;
                background: #F1F1F1;
            }

            #chat {
                width: 90%;
            }

            #chat2 {
                font-weight: bold;
            }

            #chat-btn {
                padding: 10px;
                border-radius: 10px;
                margin: 2px;
                width: 95%;
                font-size: 110%;
            }

            .chatbox__support {
                margin-left: 5%;
                width: 100%;
                height: 80vh;
            }

            .chatbox__header {
                padding: 5px;
            }

            .chatbox__heading--header {
                font-size: 0.9rem;
            }

            .chatbox__description--header {
                font-size: 0.7rem;
            }

        }

        #back-to-questions {
            font-size: medium;
            margin-top: 40px;
        }
    </style>


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
                        <p class="chatbox__description--header">Hi,How can I help you?</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div id="chat"></div>
                    <div id="chat2"></div>
                </div>
                <div class="chatbox__footer">
                    {{-- <input type="text" placeholder="Write a message...">
                    <button class="chatbox__send--footer send__button">Send</button> --}}
                </div>
            </div>
            <div class="chatbox__button" style="cursor:pointer">
                {{-- <button><img src="./images/chatbox-icon.svg" /></button> --}}
                <svg width="36" height="29" viewBox="0 0 36 29" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M28.2857 10.5714C28.2857 4.88616 21.9576 0.285714 14.1429 0.285714C6.32813 0.285714 0 4.88616 0 10.5714C0 13.8259 2.08929 16.7388 5.34375 18.6272C4.66071 20.2946 3.77679 21.0781 2.9933 21.9621C2.77232 22.2232 2.51116 22.4643 2.59152 22.846C2.65179 23.1875 2.93304 23.4286 3.23438 23.4286C3.25446 23.4286 3.27455 23.4286 3.29464 23.4286C3.89732 23.3482 4.47991 23.2478 5.02232 23.1071C7.05134 22.5848 8.93973 21.721 10.6071 20.5357C11.7321 20.7366 12.9174 20.8571 14.1429 20.8571C21.9576 20.8571 28.2857 16.2567 28.2857 10.5714ZM36 15.7143C36 12.3594 33.7902 9.38616 30.3951 7.51786C30.6964 8.50223 30.8571 9.52679 30.8571 10.5714C30.8571 14.1674 29.0089 17.4821 25.654 19.933C22.5402 22.183 18.4621 23.4286 14.1429 23.4286C13.5603 23.4286 12.9576 23.3884 12.375 23.3482C14.8862 24.9955 18.221 26 21.8571 26C23.0826 26 24.2679 25.8795 25.3929 25.6786C27.0603 26.8638 28.9487 27.7277 30.9777 28.25C31.5201 28.3906 32.1027 28.4911 32.7054 28.5714C33.0268 28.6116 33.3281 28.3504 33.4085 27.9888C33.4888 27.6071 33.2277 27.3661 33.0067 27.1049C32.2232 26.221 31.3393 25.4375 30.6563 23.7701C33.9107 21.8817 36 18.9888 36 15.7143Z"
                        fill="#581B98" />
                </svg>
            </div>
        </div>
    </div>

    <script>
        class Chatbox {
            constructor() {
                this.args = {
                    openButton: document.querySelector('.chatbox__button'),
                    chatBox: document.querySelector('.chatbox__support'),
                    sendButton: document.querySelector('.send__button')
                }

                this.state = false;
                this.messages = [];
            }

            display() {
                const {
                    openButton,
                    chatBox,
                    sendButton
                } = this.args;

                openButton.addEventListener('click', () => this.toggleState(chatBox))

                sendButton.addEventListener('click', () => this.onSendButton(chatBox))

                const node = chatBox.querySelector('input');
                node.addEventListener("keyup", ({
                    key
                }) => {
                    if (key === "Enter") {
                        this.onSendButton(chatBox)
                    }
                })
            }

            toggleState(chatbox) {
                this.state = !this.state;

                // show or hides the box
                if (this.state) {
                    chatbox.classList.add('chatbox--active')
                } else {
                    chatbox.classList.remove('chatbox--active')
                }
            }

            onSendButton(chatbox) {
                var textField = chatbox.querySelector('input');
                let text1 = textField.value
                if (text1 === "") {
                    return;
                }

                let msg1 = {
                    name: "User",
                    message: text1
                }
                this.messages.push(msg1);

                fetch('http://127.0.0.1:5000/predict', {
                        method: 'POST',
                        body: JSON.stringify({
                            message: text1
                        }),
                        mode: 'cors',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(r => r.json())
                    .then(r => {
                        let msg2 = {
                            name: "Sam",
                            message: r.answer
                        };
                        this.messages.push(msg2);
                        this.updateChatText(chatbox)
                        textField.value = ''

                    }).catch((error) => {
                        console.error('Error:', error);
                        this.updateChatText(chatbox)
                        textField.value = ''
                    });
            }

            updateChatText(chatbox) {
                var html = '';
                this.messages.slice().reverse().forEach(function(item, index) {
                    if (item.name === "Sam") {
                        html += '<div class="messages__item messages__item--visitor">' + item.message + '</div>'
                    } else {
                        html += '<div class="messages__item messages__item--operator">' + item.message +
                            '</div>'
                    }
                });

                const chatmessage = chatbox.querySelector('.chatbox__messages');
                chatmessage.innerHTML = html;
            }
        }


        const chatbox = new Chatbox();
        chatbox.display();
    </script>

    <script>
        $(document).ready(function() {
            $('body').on('click', '.category-btn', function() {
                var category = $(this).data('category');
                console.log("Category clicked:", category);
                loadSubCat1(category);
            });

            $('body').on('click', '.subCat1-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                console.log("SubCat1 clicked:", category, subCat1);
                loadSubCat2(category, subCat1);
            });

            $('body').on('click', '.subCat2-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                console.log("SubCat2 clicked:", category, subCat1, subCat2);
                loadQuestions(category, subCat1, subCat2);
            });

            $('body').on('click', '.question-btn', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                var question = $(this).data('question');
                console.log("Question clicked:", category, subCat1, subCat2, question);
                getAnswer(category, subCat1, subCat2, question);
            });

            // Back button handlers
            $('body').on('click', '#back-to-categories', function() {
                console.log("Back to categories clicked");
                loadCategories();
            });

            $('body').on('click', '#back-to-subCat1', function() {
                var category = $(this).data('category');
                console.log("Back to SubCat1 clicked:", category);
                loadSubCat1(category);
            });

            $('body').on('click', '#back-to-subCat2', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                console.log("Back to SubCat2 clicked:", category, subCat1);
                loadSubCat2(category, subCat1);
            });

            $('body').on('click', '#back-to-questions', function() {
                var category = $(this).data('category');
                var subCat1 = $(this).data('subcat1');
                var subCat2 = $(this).data('subcat2');
                console.log("Back to questions clicked:", category, subCat1, subCat2);
                loadQuestions(category, subCat1, subCat2);
            });

            $('body').on('click', '#home', function() {
                console.log("Home clicked");
                loadCategories();
            });

            // Load initial categories
            loadCategories();
        });

        function loadCategories() {
            $.ajax({
                url: '/chatbot',
                type: 'GET',
                success: function(response) {
                    console.log("Categories loaded:", response);
                    var categoriesHtml =
                        '@foreach ($categories as $category) <button class="category-btn" id="chat-btn" data-category="{{ $category->Category }}">{{ $category->Category }}</button> @endforeach';
                    $('#chat').html(categoriesHtml);
                    var text = '<p style="color:black;">Please select a category</p>';
                    $('#chat2').html(text);
                }
            });
        }

        function loadSubCat1(category) {
            console.log("Loading subCat1 for:", category);
            $.ajax({
                url: '/getSubCat1Options',
                type: 'GET',
                data: {
                    category: category
                },
                success: function(response) {
                    console.log("SubCat1 options loaded:", response);
                    var subCat1Html = "";
                    response.options.forEach(function(option) {
                        subCat1Html += '<button class="subCat1-btn" id="chat-btn" data-category="' +
                            category +
                            '" data-subcat1="' + option.SubCat1 + '">' + option.SubCat1 + '</button>';
                    });
                    subCat1Html += '<button id="back-to-categories" class="chat-btn">Back</button>';
                    $('#chat').html(subCat1Html);
                    var text = '<p style="color:black;">You select ' + category + ' </p>';
                    $('#chat2').html(text);
                }
            });
        }

        function loadSubCat2(category, subCat1) {
            console.log("Loading subCat2 for:", category, subCat1);
            $.ajax({
                url: '/getSubCat2Options',
                type: 'GET',
                data: {
                    category: category,
                    subCat1: subCat1
                },
                success: function(response) {
                    console.log("SubCat2 options loaded:", response);
                    var subCat2Html = "";
                    response.options.forEach(function(option) {
                        subCat2Html += '<button class="subCat2-btn" id="chat-btn" data-category="' +
                            category +
                            '" data-subcat1="' + subCat1 + '" data-subcat2="' + option.SubCat2 + '">' +
                            option.SubCat2 + '</button>';
                    });
                    subCat2Html += '<button id="back-to-subCat1" class="chat-btn" data-category="' +
                        category +
                        '">Back</button>';
                    $('#chat').html(subCat2Html);
                    var text = '<p style="color:black;">You select ' + subCat1 + ' </p>';
                    $('#chat2').html(text);
                }
            });
        }

        function loadQuestions(category, subCat1, subCat2) {
            console.log("Loading questions for:", category, subCat1, subCat2);
            $.ajax({
                url: '/getQuestions',
                type: 'GET',
                data: {
                    category: category,
                    subCat1: subCat1,
                    subCat2: subCat2
                },
                success: function(response) {
                    console.log("Questions loaded:", response);
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
                        '" data-subcat1="' + subCat1 + '">Back</button>';
                    $('#chat').html(questionsHtml);
                    var text = '<p style="color:black;">You select ' + subCat2 + ' </p>';
                    $('#chat2').html(text);
                }
            });
        }

        function getAnswer(category, subCat1, subCat2, question) {
            console.log("Getting answer for:", category, subCat1, subCat2, question);
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
                    console.log("Answer loaded:", response);
                    var answerHtml = "";
                    if (response.answer) {
                        answerHtml += '<p style="color:black; font-size:large;">' + response.answer + '</p>';
                    } else {
                        answerHtml += '<p>Error: No answer found for the selected question</p>';
                    }
                    answerHtml +=
                        '<button id="back-to-questions" class="chat-btn" data-category="' + category +
                        '" data-subcat1="' + subCat1 + '" data-subcat2="' + subCat2 +
                        '">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(answerHtml);
                    var text = '<p style="color:black;">You select ' + question + ' </p>';
                    $('#chat2').html(text);
                }
            });
        }
    </script>

</body>

</html>
