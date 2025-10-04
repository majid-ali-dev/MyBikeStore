@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.customer-sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card border-success shadow">
                                <div
                                    class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">
                                        <i class="fas fa-comment-medical me-2"></i>
                                        Support Live Chat
                                    </h3>
                                    <div>
                                        <!-- Status badges removed -->
                                        <span class="badge bg-light text-success">Live Support</span>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="d-flex flex-column" style="height: 500px;">
                                        <!-- Messages Area -->
                                        <div class="flex-grow-1 p-3" style="overflow-y: auto; background: #f8f9fa;"
                                            id="messagesArea">
                                            <div class="text-center text-muted py-4">
                                                <i class="fas fa-robot fa-2x mb-3 text-success"></i>
                                                <p>Welcome to MyBikeStore Support! How can we help you today?</p>
                                            </div>
                                        </div>

                                        <!-- Message Input -->
                                        <div class="p-3 border-top bg-white">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="Type your message here..." id="messageInput">
                                                <button class="btn btn-success" type="button" id="sendMessageBtn">
                                                    <i class="fas fa-paper-plane"></i> Send
                                                </button>
                                            </div>
                                            <small class="text-muted mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Our support team typically responds within 5-10 minutes
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-message {
            margin-bottom: 15px;
            animation: fadeIn 0.3s;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .customer-message {
            background: #28a745;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }

        .admin-message {
            background: white;
            color: #333;
            border: 1px solid #dee2e6;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .message-sender {
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }

        .system-message {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            margin: 10px 0;
        }

        .new-message-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            animation: slideIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }
    </style>

    <!-- Include Pusher and jQuery -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pusher configuration
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true,
                authEndpoint: '/broadcasting/auth'
            });

            // Load messages
            function loadMessages() {
                $.get('{{ route('customer.chat.messages') }}', function(messages) {
                    $('#messagesArea').html('');

                    if (messages.length === 0) {
                        $('#messagesArea').html(`
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-robot fa-2x mb-3 text-success"></i>
                                <p>Welcome to MyBikeStore Support! How can we help you today?</p>
                            </div>
                        `);
                        return;
                    }

                    messages.forEach(message => {
                        appendMessage(message);
                    });

                    scrollToBottom();
                }).fail(function() {
                    $('#messagesArea').html(`
                        <div class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <p>Failed to load messages. Please refresh the page.</p>
                        </div>
                    `);
                });
            }

            // Append message to chat
            function appendMessage(message) {
                const isCustomer = message.sender_id === {{ auth()->id() }};
                const messageClass = isCustomer ? 'customer-message' : 'admin-message';
                const time = new Date(message.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const senderName = isCustomer ? 'You' : (message.sender ? message.sender.name : 'Support');

                // Safely get message text
                const messageText = typeof message.message === 'string' ? message.message :
                    (message.message && typeof message.message === 'object' ?
                        (message.message.message || 'Invalid message') : 'Invalid message');

                $('#messagesArea').append(`
                    <div class="chat-message d-flex ${isCustomer ? 'justify-content-end' : 'justify-content-start'}">
                        <div class="message-bubble ${messageClass}">
                            ${!isCustomer ? `<div class="message-sender text-primary">${senderName}</div>` : ''}
                            <div class="message-text">${messageText}</div>
                            <div class="message-time ${isCustomer ? 'text-end' : ''}">${time}</div>
                        </div>
                    </div>
                `);
            }

            // Send message
            function sendMessage() {
                const message = $('#messageInput').val().trim();
                if (!message) return;

                // Show message immediately for better UX
                const tempMessage = {
                    sender_id: {{ auth()->id() }},
                    message: message,
                    created_at: new Date().toISOString(),
                    sender: {
                        name: 'You'
                    }
                };
                appendMessage(tempMessage);
                scrollToBottom();

                // Clear input
                $('#messageInput').val('');

                // Send to server
                $.post('{{ route('customer.chat.send') }}', {
                    message: message,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    // Message already shown, just scroll
                    scrollToBottom();
                }).fail(function() {
                    // Show error message
                    $('#messagesArea').append(`
                        <div class="system-message text-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Failed to send message. Please try again.
                        </div>
                    `);
                    scrollToBottom();
                });
            }

            // Scroll to bottom
            function scrollToBottom() {
                const messagesArea = $('#messagesArea');
                messagesArea.scrollTop(messagesArea[0].scrollHeight);
            }

            // Event listeners
            $('#sendMessageBtn').click(sendMessage);

            $('#messageInput').keypress(function(e) {
                if (e.which === 13) {
                    sendMessage();
                }
            });

            // Pusher channel for receiving messages
            const channel = pusher.subscribe('private-chat.{{ auth()->id() }}');
            channel.bind('new-chat-message', function(data) {
                const message = data.chatMessage;

                // Only append if message is from admin
                if (message.sender_id !== {{ auth()->id() }}) {
                    appendMessage(message);
                    scrollToBottom();

                    // Show visual alert for new message
                    showMessageAlert();
                }
            });

            // Show message alert
            function showMessageAlert() {
                $('.new-message-alert').remove();
                $('body').append(`
                    <div class="alert alert-success new-message-alert">
                        <i class="fas fa-comment-dots me-2"></i>
                        New message from support!
                    </div>
                `);

                setTimeout(() => {
                    $('.new-message-alert').fadeOut();
                }, 3000);
            }

            // Request notification permission
            if ("Notification" in window && Notification.permission === "default") {
                Notification.requestPermission();
            }

            // Auto-refresh messages every 30 seconds (fallback)
            setInterval(loadMessages, 30000);

            // Initial load
            loadMessages();
        });
    </script>
@endsection
