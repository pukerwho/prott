var $ = require("jquery");
$('.task-author-js').on('click', function(){
  let taskId = $(this).data('task-id');
  let taskSite = $(this).data('task-site');
  let taskAuthor = $('.author-select[data-select-id="'+taskId+'"]').val();
  
  if (taskAuthor != 'Оберіть автора') {
    let data = {
      'action': 'task_author_click_action',
      'taskId': taskId,
      'taskSite': taskSite,
      'taskAuthor': taskAuthor,
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
  }
  
})