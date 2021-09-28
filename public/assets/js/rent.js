$("#rentType").change(function () {
  var rentType = $("#rentType :selected").val();
  if (rentType == 2) {
    $("#returnDateTime").show();
  } else {
    $("#returnDateTime").hide();
  }
});

$(document).on('click', '#rentDelete', function () {
    console.log('id = ')
    $('#rentDeleteModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
});

$("#rentDestroy").click(function(){
  $.ajax({
      type: 'POST',
      url: '/rent/destroy',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        id: $('input[name=del_id]').val()
      },
      success: function (data) {
          $('#rentDeleteModal').modal('hide');
          $('.rent-' + $('input[name=del_id]').val()).remove();
          toastr.success('Rent Deleted')
      }
  });
});

$(document).on('click', '#statusChange', function () {
  $('#statusUpdateModal').modal('show');
  $('#rent_id').val($(this).data('id'));
  $('#status').val($(this).data('status'));
});

$("#changeRentStatus").click(function(e){
  e.preventDefault();
  
  var rent_id = $("#rent_id").val();
  var status   = $("#status :selected").val();
  
  $.ajax({
      type: 'POST',
      url: '/rent/status-update',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        rent_id : rent_id,
        status : status
      },
      success: function (data) {
          $('#statusUpdateModal').modal('hide');
          toastr.success('Status Update Successfully')
      }
  });
});



// get car model
$("#car_type_id").change(function(){
  var car_type_id = $(this).val();
  $.get('/get-car-model/'+ car_type_id, function(response){
      $('#model_id').empty();
      $('#model_id').append('<option value="0">Select</option');
      for(var i = 0; i <= response.length; i++){
          $('#model_id').append('<option value="'+ response[i].id +'">'+ response[i].name +'</option');
      }
  });
});

//get brand by car_type_id
$("#filter_car_type_id").change(function(){
  var car_type_id = $(this).val();
  $.get('/get-car-model/'+ car_type_id, function(response){
      $('#filter_model_id').empty();
      $('#filter_model_id').append('<option value="0">Select</option');
      for(var i = 0; i <= response.length; i++){
          $('#filter_model_id').append('<option value="'+ response[i].id +'">'+ response[i].name +'</option');
      }
  });
});

$(document).on('click', '#sms', function () {
  $('#smsModal').modal('show');
  $('#rentId').val($(this).data('id'));
});

$("#sendSMS").click(function(e){
  e.preventDefault();
  
  var rent_id = $("#rentId").val();
  var smsFor = $("#smsFor :selected").val();
  var message = $("#message").val();
  
  $.ajax({
      type: 'POST',
      url: '/rent/send-sms',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        rent_id : rent_id,
        smsFor : smsFor,
        message : message
      },
      success: function (data) {
        $('#smsModal').modal('hide');
        toastr.success('SMS Send Successfully')
      }
  });
});