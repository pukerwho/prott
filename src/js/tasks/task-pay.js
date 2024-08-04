var $ = require("jquery");
$('.task-pay-js').on('click', function(){
  let postID = $(this).data('post-id');
  let data = {
    'action': 'task_pay_click_action',
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
        $('.task-pay-wait-js[data-post-id="'+postID+'"]').addClass('bg-green-500').text('Оплачено');
        // $('.task-pay-success-js[data-post-id="'+postID+'"]').removeClass('hidden');
      }
    }
  });
})