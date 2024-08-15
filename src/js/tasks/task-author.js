var $ = require("jquery");
$('.task-author-edit-js').on('click', function(){
  let taskId = $(this).data('task-id');
  $('.author-task[data-task-id="'+taskId+'"]').addClass('hidden');
  $('.author-task-choose[data-task-id="'+taskId+'"]').removeClass('hidden').addClass('flex');
});
$('.task-author-js').on('click', function(){
  let postId = $(this).data('post-id');
  let taskAuthor = $('.author-select[data-select-id="'+postId+'"]').val();
  
  if (taskAuthor != 'Оберіть автора') {
    let data = {
      'action': 'task_author_click_action',
      'postId': postId,
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