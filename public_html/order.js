$(function() {
  'use strict';

  $('input').first().focus();

  $('.btn').on('click', function() {
    $('#form').submit();
  });

  $('.btn').on('click', function() {
    $('#addform').submit();
  });

  $('#back').on('click', function() {
    window.location.href = '/';
  });

  $(".delete").on('click', function() {
    var cd = $(this).parent('tr').data('id');

      $.post('_ajax.php', {
        cd: cd,
        mode: 'delete',
      }, function() {
        $("#order_" + cd).fadeOut(800);
      });
  });


});
