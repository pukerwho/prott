var $ = require("jquery");
$('.task-accept-js').on('click', function () {
  let postID = $(this).data('post-id');
  let authorAccept = $(this).data('author-accept');
  console.log(postID);
  let data = {
    'action': 'task_accept_click_action',
    'postID': postID,
    'authorAccept': authorAccept
  };
  $.ajax({
    url: ajaxurl, // AJAX handler
    data: data,
    type: 'POST',
    beforeSend: function (xhr) {
      console.log('Загружаю');
    },
    success: function (data) {
      if (data) {
        console.log(data);
        window.location.reload();
      }
    }
  });
})