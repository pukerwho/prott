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
        window.location.reload();
      }
    }
  });
});

$('.js-all-pay').on('click', function(){
  let payAuthor = $(this).data('pay-author');
  let data = {
    'action': 'task_all_pay_click_action',
    'payAuthor': payAuthor,
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
});