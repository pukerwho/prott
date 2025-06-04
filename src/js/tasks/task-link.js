var $ = require("jquery");
$('.task-link-js').on('click', function () {

  let taskId = $(this).data('task-id');
  let postID = $(this).data('post-id');
  let taskSite = $(this).data('task-site');
  let clbrType = $(this).data('clbr-type');
  let taskLink = $('.task-link[data-inputlink-id="' + postID + '"]').val();
  let data = {
    'action': 'task_link_click_action',
    'taskId': taskId,
    'postID': postID,
    'taskLink': taskLink,
    'clbrType': clbrType,
  };
  if (taskLink != '') {
    if (taskLink.includes(taskSite)) {
      $.ajax({
        url: ajaxurl, // AJAX handler
        data: data,
        type: 'POST',
        beforeSend: function (xhr) {
          console.log('Загружаю');
        },
        success: function (data) {
          if (data) {
            console.log('записали');
            console.log(data);
            window.location.reload();
          }
        }
      });
    } else {
      $('.task-link-error[data-task-id="' + postID + '"]').removeClass('hidden');
      $('.task-link-error[data-task-id="' + postID + '"]').text('Сайт не співпадає');
    }
  }
})