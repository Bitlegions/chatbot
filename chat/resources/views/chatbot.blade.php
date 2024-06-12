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
            width: 300px;
            height: 350px;
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
            background: orange;
        }

        /* MESSAGES */
        .chatbox__messages {
            margin-top: auto;
            display: flex;
            overflow-y: scroll;
            flex-direction: column-reverse;
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
            height: 450px;
            width: 350px;
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
            justify-content: center;
            padding: 15px 20px;
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
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 90%;
        }

        #chat-btn {
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            width: 95%
        }

        .chat-btn {
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
            padding: 20px 20px;
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
                        <h4 class="chatbox__heading--header">Chat support</h4>
                        <p class="chatbox__description--header">Hi. My name is Sam. How can I help you?</p>
                    </div>
                </div>
                <div class="chatbox__messages">
                    <div id="chat"></div>
                </div>
                <div class="chatbox__footer">
                    <input type="text" placeholder="Write a message...">
                    <button class="chatbox__send--footer send__button">Send</button>
                </div>
            </div>
            <div class="chatbox__button">
                <button><img src="./images/chatbox-icon.svg" /></button>
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
                        answerHtml += '<p>' + response.answer + '</p>';
                    } else {
                        answerHtml += '<p>Error: No answer found for the selected question</p>';
                    }
                    answerHtml +=
                        '<button id="back-to-questions" class="chat-btn" data-category="' + category +
                        '" data-subcat1="' + subCat1 + '" data-subcat2="' + subCat2 +
                        '">Back</button><button id="home" class="chat-btn">Home</button>';
                    $('#chat').html(answerHtml);
                }
            });
        }
    </script>

</body>

</html>
