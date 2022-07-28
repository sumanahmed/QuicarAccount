
function calculatePrice () {
  var rentType      = $( "#rentType option:selected" ).val();
  var price         = $("#price").val() > 0 ? parseFloat($("#price").val()) : 0;
  var bodyRent      = $("#body_rent").val() > 0 ? parseFloat($("#body_rent").val()) : 0;
  var totalVehicle  = $("#total_vehicle").val() > 0 ? parseFloat($("#total_vehicle").val()) : 1;
  var totalDay      = $("#total_day").val() > 0 ? parseFloat($("#total_day").val()) : 1;
  var advance       = $("#advance").val() > 0 ? parseFloat($("#advance").val()) : 0;

  if (rentType === 3) {
    var newPrice = parseFloat(bodyRent * (totalVehicle * totalDay));
    var newRemaining = parseFloat(newPrice - advance);

    $("#price").val(newPrice);
    $("#remaining").val(newRemaining);
  } else {
    var newPrice = parseFloat(price * (totalVehicle * totalDay));
    var newRemaining = parseFloat(newPrice - advance);

    $("#price").val(newPrice);
    $("#remaining").val(newRemaining);
  }
  
}

$("#status").change(function () {
  var status = $("#status :selected").val();
  if (status == 3) {
    $("#showCost").show();
  } else {
    $("#showCost").hide();
  }
});

$("#rentType").change(function () {
  var rentType = $("#rentType :selected").val();
  if (rentType == 2) {
    $("#returnDateTime").show();    
    $("#bodyRent").hide();
    $("#fuleCost").hide();
    $("#driverAccomodation").hide();
  } else if (rentType == 3) {
    $("#returnDateTime").show();
    $("#bodyRent").show();
    $("#fuleCost").show();
    $("#driverAccomodation").show();
  } else {
    $("#returnDateTime").hide();
    $("#bodyRent").hide();
    $("#fuleCost").hide();
    $("#driverAccomodation").hide();
  }
});

$(document).on('click', '#rentDelete', function () {
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

  var rent_id       = parseInt($("#rent_id").val());
  var status        = parseInt($("#status :selected").val());
  var driver_get    = parseFloat($("#driverCost").val());
  var fuel_cost     = parseFloat($("#fuelCost").val());
  var other_cost    = parseFloat($("#otherCost").val());
  var toll_charge   = parseFloat($("#tollCharge").val());
  var total_km      = parseFloat($("#totalKm").val());

  $.ajax({
      type: 'POST',
      url: '/rent/status-update',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        rent_id : rent_id,
        status : status,
        driver_get : driver_get,
        fuel_cost : fuel_cost,
        other_cost : other_cost,
        toll_charge : toll_charge,
        total_km : total_km,
      },
      success: function (response) {
        $("#hideStatusModalyBody").hide();
        $("#loader").show();
        // if((response.errors)){
        //     if(response.errors.driver_get){
        //         $('.errorDriverCost').text(response.errors.driver_get);
        //     }else{
        //         $('.errorDriverCost').text('');
        //     } 
        //     if(response.errors.fuel_cost){
        //         $('.errorFuelCost').text(response.errors.fuel_cost);
        //     }else{
        //         $('.errorFuelCost').text('');
        //     }
        //     if(response.errors.other_cost){
        //         $('.errorOtherCost').text(response.errors.other_cost);
        //     }else{
        //         $('.errorOtherCost').text('');
        //     }
        // } else {
            $('#statusUpdateModal').modal('hide');
            toastr.success('Status Update Successfully')
            // location.reload();
            $("#loader").hide();
        // }
        // $("#loader").hide();
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