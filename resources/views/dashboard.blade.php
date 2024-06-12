<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="row mt-3">
            @if (count($users) > 0)
                <div class="col-md-3">
                    <ul class="list-group">
                        @foreach ($users as $index => $user)
                        <li class="list-group-item list-group-item-dark "style="cursor:pointer" data-id="{{$user->id}}">
                            @if($user->image)
                            <img src="{{ asset('spaces/'.$user->image) }}"
                            onerror="this.src='/user-icon.png'"
                            class="d-inline rounded-circle" alt="" style="width: 50px; height: 50px;">
                        @else
                            <img src="/user-icon.png" class="d-inline rounded-circle" alt="" style="width: 50px; height: 50px;">
                        @endif
                        
                            {{$user->name}}
                            <span id="{{$user->id}}-status" class="status-indicator offline"></span>
                        </li>
                        
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="chat-section">
                        <div class="chat-container" id="chat-container">
                            <!-- Example messages, these should be generated dynamically -->
                           
                            
                        </div>
                        <form action="" class="chat-form" >
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type a message..." id="message" name="message">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h4>No Users Found</h4>
                </div>
            @endif
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete Message</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="/delete-chat" method="POST" id="delete-chat-form">
                        @csrf
                        <input type="hidden" name="id" id="delete-chat-id">
                        <p>Are you sure you want to delete the message below?</p>
                        
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
    
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
    
            </div>
        </div>
    </div>
    
    
<style>
    .chat-container {
    background-color: lightgray;
    overflow-y: scroll;
    height: 400px;
    width: 100%;
    padding: 10px;
    display: flex;
    flex-direction: column;
}

.chat-message {
    display: flex;
    padding: 10px;
    margin: 5px 0;
    border-radius: 10px;
    max-width: 60%;
    word-wrap: break-word;
}

/* Align current user chat to the right */
.current-chat {
    align-self: flex-end;
    background-color: #d1e7dd; /* Light green background */
    text-align: right;
}

/* Align other user chat to the left */
.other-chat {
    align-self: flex-start;
    background-color: #f8d7da; /* Light red background */
    text-align: left;
}
.chat-form {
    margin-top: 10px;
}

.chat-form .input-group {
    display: flex;
    align-items: center;
}

.chat-form .form-control {
    height: 45px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    border-right: none;
}

.chat-form .input-group-append .btn-primary {
    height: 45px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}
.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-left: 10px;
    vertical-align: middle;
}

.status-indicator.online {
    background-color: #28a745; /* Green color for online */
}

.status-indicator.offline {
    background-color: #dc3545; /* Red color for offline */
}
.chat-section{
    display:none;
}
</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  
</x-app-layout>
