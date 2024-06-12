<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
</head>
<body>
    <h1>Chatbot</h1>
    <div id="chat"></div>

    <script>
        var selectedCategory = null; // Variable to store the selected category

        function sendMessage(message) {
            // Display user message
            displayMessage(message, 'user');

            // If message is a category, store it and fetch subcategories
            if (data[message]) {
                selectedCategory = message; // Store the selected category
                displaySubcategories(data[message]);
            } else {
                // If message is a subcategory, fetch answer
                fetchAnswer(message);
            }
        }

        function displaySubcategories(subcategories) {
            // Clear previous messages
            document.getElementById('chat').innerHTML = '';

            // Display subcategories as buttons
            Object.keys(subcategories).forEach(subcategory => {
                var button = document.createElement('button');
                button.innerText = subcategory;
                button.onclick = function() {
                    sendMessage(subcategory);
                };
                document.getElementById('chat').appendChild(button);
            });
        }

        function fetchAnswer(subcategory) {
    fetch('/get_answer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ category: selectedCategory, subcategory: subcategory }),
    })
    .then(response => response.json())
    .then(data => {
        // Display answer
        if (data.answer) {
            displayMessage(data.answer, 'bot');
        } else {
            displayMessage('Error: No answer found', 'bot');
        }
    })
    .catch(error => {
        console.error('Error fetching answer:', error);
        displayMessage('Error: Failed to fetch answer', 'bot');
    });
}


        function displayMessage(message, sender) {
            var chatDiv = document.getElementById('chat');
            var messageDiv = document.createElement('div');
            messageDiv.className = 'message';
            messageDiv.innerHTML = '<strong>' + sender + ':</strong> ' + message;
            chatDiv.appendChild(messageDiv);
        }

        // Display categories as buttons when the page loads
        var data = {!! json_encode($data) !!};
        Object.keys(data).forEach(category => {
            var button = document.createElement('button');
            button.innerText = category;
            button.onclick = function() {
                sendMessage(category);
            };
            document.getElementById('chat').appendChild(button);
        });
    </script>
</body>
</html>
