$("#delete").click(function(){
    $('#deleteModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
});

$("#destroy").click(function(){
  $.ajax({
      type: 'POST',
      url: '/reminder/destroy',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        id: $('input[name=del_id]').val()
      },
      success: function (data) {
          $('#deleteModal').modal('hide');
          $('.reminder-' + $('input[name=del_id]').val()).remove();
          toastr.success('Reminder Deleted')
      }
  });
});

$("#sms").click(function(){
  $('#smsModal').modal('show');
  $('#customerName').val($(this).data('name'));
  $('#customerPhone').val($(this).data('phone'));
  $('#reminderId').val($(this).data('id'));
});

$("#sendSMS").click(function(e){
  e.preventDefault();
  
  var reminder_id = $("#reminderId").val();
  var name = $("#customerName").val();
  var phone = $("#customerPhone").val();
  var message = $("#message").val();
  
  $.ajax({
      type: 'POST',
      url: '/reminder/send-sms',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        reminder_id : reminder_id,
        name : name,
        phone : phone,
        message : message
      },
      success: function (data) {
          $('#smsModal').modal('hide');
          toastr.success('SMS Send Successfully')
      }
  });
});