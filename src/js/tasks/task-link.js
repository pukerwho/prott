var $ = require("jquery");
$('.task-link-js').on('click', function(){
  
  let taskId = $(this).data('task-id');
  let postID = $(this).data('post-id');
  let taskLink = $('.task-link[data-inputlink-id="'+postID+'"]').val();
  let data = {
    'action': 'task_link_click_action',
    'taskId': taskId,
    'postID': postID,
    'taskLink': taskLink,
  };
  if (taskLink != '') {
    console.log('go');
    $.ajax({
      url: ajaxurl, // AJAX handler
      data: data,
      type: 'POST',
      beforeSend : function(xhr) {
        console.log('Загружаю');
      },
      success : function(data) {
        if (data) {
          console.log('записали');
          console.log(data);
          window.location.reload();
        }
      }
    });
  }
})