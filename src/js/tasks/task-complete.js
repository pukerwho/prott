var $ = require("jquery");
$('.task-complete-js').on('click', function(){
  let postID = $(this).data('post-id');
  let data = {
    'action': 'task_complete_click_action',
    'postID': postID,
  };
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
})