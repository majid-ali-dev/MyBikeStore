@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0">
        <div class="row g-0">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-dark d-md-none mb-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">
                                        <i class="fas fa-headset me-2"></i>
                                        Customer Support Chat
                                    </h3>
                                    <div>
                                        <span class="badge bg-warning me-2" id="onlineCount">Live Chat</span>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <!-- Customers List -->
                                        <div class="col-md-4 border-end">
                                            <div class="p-3 border-bottom">
                                                <input type="text" class="form-control" placeholder="Search customers..."
                                                    id="searchCustomers">
                                            </div>
                                            <div class="customers-list" style="height: 600px; overflow-y: auto;"
                                                id="customersList">
                                                <div class="text-center text-muted py-5">
                                                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                                                    <p>Loading customers...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chat Area -->
                                        <div class="col-md-8">
                                            <div class="d-flex flex-column" style="height: 600px;">
                                                <!-- Chat Header -->
                                                <div class="p-3 border-bottom bg-light">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="mb-0" id="currentCustomerName">Select a customer to
                                                                start chatting</h5>
                                                            <small class="text-muted" id="customerStatus">Ready to
                                                                chat</small>
                                                        </div>
                                                        <!-- Settings dropdown removed -->
                                                    </div>
                                                </div>

                                                <!-- Messages Area -->
                                                <div class="flex-grow-1 p-3" style="overflow-y: auto; height: 400px;"
                                                    id="messagesArea">
                                                    <div class="text-center text-muted py-5">
                                                        <i class="fas fa-comments fa-3x mb-3"></i>
                                                        <p>Select a customer to view messages</p>
                                                    </div>
                                                </div>

                                                <!-- Message Input -->
                                                <div class="p-3 border-top bg-light">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Type your message..." id="messageInput" disabled>
                                                        <input type="hidden" id="currentCustomerId">
                                                        <button class="btn btn-primary" type="button" id="sendMessageBtn"
                                                            disabled>
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
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
            </div>
        </div>
    </div>

    <style>
        .chat-message {
            margin-bottom: 15px;
            animation: fadeIn 0.3s;
        }

        .message-bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .admin-message {
            background: #007bff;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }

        .customer-message {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .customer-item {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
            position: relative;
        }

        .customer-item:hover {
            background-color: #f8f9fa;
        }

        .customer-item.active {
            background-color: #e3f2fd;
            border-left: 4px solid #007bff;
        }

        .unread-badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 10px;
            right: 15px;
        }

        .new-message-indicator {
            position: absolute;
            top: 10px;
            right: 40px;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .no-customers-found {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
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

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
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

            let currentCustomerId = null;
            let customersData = [];

            // Load customers list
            function loadCustomers() {
                $.get('{{ route('admin.chat.customers') }}', function(data) {
                    customersData = data;
                    renderCustomersList('');
                }).fail(function() {
                    $('#customersList').html(
                        '<div class="text-center text-muted py-5"><i class="fas fa-exclamation-triangle fa-2x mb-3"></i><p>Failed to load customers</p></div>'
                    );
                });
            }

            // Render customers list with search filter
            function renderCustomersList(searchTerm = '') {
                $('#customersList').html('');

                let filteredCustomers = customersData;

                // Apply search filter
                if (searchTerm.trim() !== '') {
                    const term = searchTerm.toLowerCase();
                    filteredCustomers = customersData.filter(customer =>
                        customer.name.toLowerCase().includes(term)
                    );
                }

                if (filteredCustomers.length === 0) {
                    $('#customersList').html(`
                        <div class="no-customers-found">
                            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                            <h6>No customers found</h6>
                            <p class="small text-muted">
                                ${searchTerm ? 'No customers match your search' : 'No customers available for chat'}
                            </p>
                        </div>
                    `);
                    return;
                }

                filteredCustomers.forEach(customer => {
                    const lastMessage = customer.last_message ? customer.last_message.message :
                        'No messages yet';
                    const unreadCount = customer.unread_messages_count || 0;
                    const truncatedMessage = lastMessage.length > 30 ? lastMessage.substring(0, 30) +
                        '...' : lastMessage;

                    $('#customersList').append(`
                        <div class="customer-item" data-customer-id="${customer.id}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1 me-3">
                                    <h6 class="mb-1 fw-bold">${customer.name}</h6>
                                    <p class="mb-1 text-muted small">${truncatedMessage}</p>
                                </div>
                                ${unreadCount > 0 ? `<span class="unread-badge">${unreadCount}</span>` : ''}
                            </div>
                        </div>
                    `);
                });
            }

            // Real-time search functionality
            function setupSearch() {
                let searchTimeout;
                $('#searchCustomers').on('input', function() {
                    const searchTerm = $(this).val();

                    // Clear previous timeout
                    clearTimeout(searchTimeout);

                    // Set new timeout for debouncing
                    searchTimeout = setTimeout(() => {
                        renderCustomersList(searchTerm);
                    }, 300); // 300ms delay
                });

                // Clear search on escape key
                $('#searchCustomers').on('keydown', function(e) {
                    if (e.key === 'Escape') {
                        $(this).val('');
                        renderCustomersList('');
                    }
                });
            }

            // Load messages for selected customer
            function loadMessages(customerId) {
                currentCustomerId = customerId;
                $('#currentCustomerId').val(customerId);
                $('#messageInput').prop('disabled', false);
                $('#sendMessageBtn').prop('disabled', false);

                $.get(`/admin/chat/messages/${customerId}`, function(messages) {
                    $('#messagesArea').html('');

                    if (messages.length === 0) {
                        $('#messagesArea').html(`
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comments fa-2x mb-3"></i>
                                <p>No messages yet. Start the conversation!</p>
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
                        <div class="text-center text-danger py-5">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <p>Failed to load messages</p>
                        </div>
                    `);
                });

                // Update customer info
                const customer = customersData.find(c => c.id == customerId);
                if (customer) {
                    $('#currentCustomerName').text(customer.name);
                    $('#customerStatus').text('Online'); // You can implement real online status later
                }

                // Mark as active
                $('.customer-item').removeClass('active');
                $(`[data-customer-id="${customerId}"]`).addClass('active');

                // Clear unread badge
                $(`[data-customer-id="${customerId}"] .unread-badge`).remove();
                $(`[data-customer-id="${customerId}"] .new-message-indicator`).remove();

                // Refresh customers list to update unread counts
                loadCustomers();
            }

            // Append message to chat
            function appendMessage(message) {
                const isAdmin = message.sender_id === {{ auth()->id() }};
                const messageClass = isAdmin ? 'admin-message' : 'customer-message';
                const time = new Date(message.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Safely get message text
                const messageText = typeof message.message === 'string' ? message.message :
                    (message.message && typeof message.message === 'object' ?
                        (message.message.message || 'Invalid message') : 'Invalid message');

                $('#messagesArea').append(`
                    <div class="chat-message d-flex ${isAdmin ? 'justify-content-end' : 'justify-content-start'}">
                        <div class="message-bubble ${messageClass}">
                            <div class="message-text">${messageText}</div>
                            <div class="message-time text-end">${time}</div>
                        </div>
                    </div>
                `);
            }

            // Send message
            function sendMessage() {
                const message = $('#messageInput').val().trim();
                if (!message || !currentCustomerId) return;

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
                $.post('{{ route('admin.chat.send') }}', {
                    receiver_id: currentCustomerId,
                    message: message,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    // Message already shown, just update if needed
                    console.log('Message sent successfully');
                }).fail(function() {
                    // Show error message
                    $('#messagesArea').append(`
                        <div class="chat-message d-flex justify-content-center">
                            <div class="alert alert-warning py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Failed to send message. Please try again.
                            </div>
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

            // Update customer list when new message received
            function updateCustomerListOnNewMessage(customerId) {
                if (customerId !== currentCustomerId) {
                    // Show new message indicator
                    const customerItem = $(`[data-customer-id="${customerId}"]`);
                    if (!customerItem.find('.new-message-indicator').length) {
                        customerItem.append('<div class="new-message-indicator"></div>');
                    }
                }
                loadCustomers(); // Refresh for unread counts
            }

            // Event listeners
            $(document).on('click', '.customer-item', function() {
                const customerId = $(this).data('customer-id');
                $(this).find('.new-message-indicator').remove();
                loadMessages(customerId);
            });

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

                if (message.sender_id === currentCustomerId) {
                    // If currently viewing this customer's chat, show message
                    appendMessage(message);
                    scrollToBottom();
                } else {
                    // If not viewing, update customer list with indicator
                    updateCustomerListOnNewMessage(message.sender_id);
                }

                // Always refresh customers list for unread counts
                loadCustomers();
            });

            // Auto-refresh customers list every 30 seconds
            setInterval(loadCustomers, 30000);

            // Initial setup
            loadCustomers();
            setupSearch();
        });
    </script>
@endsection
