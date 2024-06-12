$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
    }
});

$(document).ready(function(){
    $('.list-group-item').click(function(){
        var get_user_id  = $(this).attr('data-id');
        receiver_id = get_user_id;
        $('.chat-section').show()
        $('#chat-container').html('');


        $.ajax({
            url:'/chat/index',
            method:'POST',
            data:{sender_id:sender_id,receiver_id: receiver_id },
            success:function(response){
                if(response.success){
                    let chats = response.chats;
                    let html ='';
                  for(let x =0 ; x < chats.length;x++){
                    let addClass='';
                    if(chats[x].sender_id == sender_id){
                        addClass='current-chat';
                    html += '<div class="chat-message ' + addClass + '"  data-id="'+chats[x].id+'" data-bs-toggle="modal" data-bs-target="#deleteModal" ><h3>' + chats[x].message + '</h3></div>';

                    }else{
                        addClass = 'other-chat';
                    html += '<div class="chat-message ' + addClass + '"><h3>' + chats[x].message + '</h3></div>';

                    }
                  }
                  $('#chat-container').append(html);

                }
            }
        });
     })
});

$('.chat-form').submit(function(e){
    e.preventDefault();

    var message = $('#message').val();
    $.ajax({
        url: "/chat/insert",
        method: 'POST',
        data: { sender_id: sender_id, receiver_id: receiver_id, message: message },
        success: function(response){
            if(response.success){
                $('#message').val('');
                let chat = response.data.message;
                let chatId = response.data.id; 
                let html = '<div class="chat-message current-chat" data-id="' + chatId + '" data-bs-toggle="modal" data-bs-target="#deleteModal"><h3>' + chat + '</h3></div>';
                $('#chat-container').append(html);
            } else {
                alert(response.message);
            }
        }
    });
});

// Event listener for chat message click to set the chat ID in the delete modal
$(document).on('click', '.chat-message', function() {
    var chatId = $(this).data('id');
    $('#delete-chat-id').val(chatId);
});

$('#delete-chat-form').submit(function(e){
    e.preventDefault();
    var id = $('#delete-chat-id').val();

    $.ajax({
        url: "/chat/delete",
        method: 'POST',
        data: { id: id },
        success: function(response){
            if(response.success){
                $('.chat-message[data-id="' + id + '"]').remove();
                $('#deleteModal').modal('hide');
            } else {
                alert(response.message);
            }
        }
    });
});

Echo.join('status-update')
.here( (users) => {
    for( i =0;i < users.length ; i++){
        if(sender_id != users[i]['id']){
            $('#'+users[i]['id']+'-status').removeClass('offline');
            $('#'+users[i]['id']+'-status').addClass('online');
        }
    }
})
.joining((user)=>{

    $('#'+user.id+'-status').removeClass('offline');
    $('#'+user.id+'-status').addClass('online');


}).leaving((user)=>{
    
    $('#'+user.id+'-status').removeClass('online');
    $('#'+user.id+'-status').addClass('offline');

})


Echo.private('broadcast-chat').listen('ChatEvent', (data) => {
    if(receiver_id == data.chat.sender_id && sender_id ==  data.chat.receiver_id) {
        let html = '<div class="chat-message other-chat"><h3>'+data.chat.message+'</h3></div>';
        $('#chat-container').append(html);
    }
});
