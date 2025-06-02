<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width,  minimum-scale=1, maximum-scale =1, user-scalable = no , shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | Climate_Cognito</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/styles/app.css') }}">
</head>

<body>
    <div class="chatContainer">
        <div class="chatContent">
            @include('sidenav')
            <div class="chatArea">
                <div class="chatMessage">
                    <div class="topChat">
                        <div class="avatarContainer">
                            <img src="./src/assets/img/image1.png" alt="Avatar">
                            <div class="dataUser">
                                <span>Climate Cognito</span>
                                <small>Online</small>
                            </div>
                        </div>
                        <div class="right">
                            <button><i class="bi bi-info-circle"></i></button>
                        </div>
                    </div>

                    <div class="conversation">
                        @foreach (session('messages', []) as $message)
                            @if ($message['role'] == 'user')
                                <div class="cardMessage outGoing">
                                    <span>{{ $message['content'] }}</span>
                                </div>
                            @else
                                <div class="cardMessage inCamming">
                                    <span>{{ $message['content'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="bottomChat">
                        <form method="POST" action="{{ route('chat.send-message') }}" class="messageForm">
                            @csrf
                            <textarea type="text" name="message" placeholder="Type your message here..."
                                class="messageInput" style="width: 912px; padding: 10px;"></textarea>
                            <button type="submit" class="sendButton"><i class="bi bi-send"></i></button>
                        </form>
                    </div>
                  
                </div>
            </div>
        </div>
         <script src="{{ asset("asset/js/soket.js")}}"></script>
    </div>
</body>

<script>
    setInterval(function() {
    $.ajax({
        type: 'GET',
        url: '/get-new-messages',
        data: {
            last_message_id: $('#last-message-id').val()
        },
        success: function(data) {
            if (data.messages.length > 0) {
                // Update the chat interface with the new messages
                $.each(data.messages, function(index, message) {
                    $('#chat-log').append('<p>' + message.content + '</p>');
                });
                $('#last-message-id').val(data.last_message_id);
            }
        }
    });
}, 5000); // Poll every 5 seconds
</script>

</html>
