var $ = require("jquery");
$('.task-complete-js').on('click', function () {
  let postID = $(this).data('post-id');
  let data = {
    'action': 'task_complete_click_action',
    'postID': postID,
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
        console.log('записали');
        console.log(data);
        // window.location.reload();
        thisBtns = document.querySelectorAll('.btn-complete[data-post-id="' + postID + '"]');
        thisBtnsReady = document.querySelectorAll('.btn-complete-ready[data-post-id="' + postID + '"]');
        if (thisBtnsReady) {
          for (thisBtnReady of thisBtnsReady) {
            thisBtnReady.textContent = 'Перевірено';
          }
        }
        for (thisBtn of thisBtns) {
          thisBtn.classList.add('bg-green-500');
          thisBtn.classList.add('text-white');
        }
      }
    }
  });
})