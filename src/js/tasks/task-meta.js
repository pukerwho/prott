var $ = require("jquery");
$('.task-meta-js').on('click', function(){
  let postID = $(this).data('post-id');
  let postMeta = $(this).data('post-meta');
  let postMetaValue = $(this).data('post-metavalue');
  let data = {
    'action': 'task_change_meta_action',
    'postID': postID,
    'postMeta': postMeta,
    'postMetaValue': postMetaValue,
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
        console.log(data);
        window.location.reload();
      }
    }
  });
});