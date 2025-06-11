var $ = require("jquery");
$('.task-link-js').one('click', function () {
  let $button = $(this);
  $button.addClass('loading').attr('disabled', true);

  let taskId = $button.data('task-id');
  let postID = $button.data('post-id');
  let taskSite = $button.data('task-site');
  let clbrType = $button.data('clbr-type');
  let taskLink = $('.task-link[data-inputlink-id="' + postID + '"]').val();
  let data = {
    action: 'task_link_click_action',
    taskId,
    postID,
    taskLink,
    clbrType,
  };

  if (taskLink != '') {
    if (taskLink.includes(taskSite)) {
      $.ajax({
        url: ajaxurl,
        data: data,
        type: 'POST',
        beforeSend: function () {
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
      $('.task-link-error[data-task-id="' + postID + '"]').removeClass('hidden').text('Сайт не співпадає');
    }
  }
});