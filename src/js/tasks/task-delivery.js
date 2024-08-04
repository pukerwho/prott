var $ = require("jquery");
$('.task-delivery').on('click', function(){
  let taskId = $(this).data('task-id');
  let taskUser = $(this).data('task-user');
  let data = {
    'action': 'task_delivery_click_action',
    'taskId': taskId,
    'taskUser': taskUser,
  };
  // addFavToTable(data);
  $.ajax({
    url: ajaxurl, // AJAX handler
    data: data,
    type: 'POST',
    beforeSend : function(xhr) {
      console.log('Загружаю');
      $('.task-accept').addClass('hidden');
      $('.task-delivery').addClass('hidden');
      $('.task-wait').removeClass('hidden');
    },
    success : function(data) {
      if (data) {
        console.log('записали');
        console.log(data);
        $('.task-btns').addClass('hidden');
        $('.task-wait').addClass('hidden');
        $('.task-create').removeClass('hidden');
        $('.task-create-delivery').removeClass('hidden');
      }
    }
  });
})