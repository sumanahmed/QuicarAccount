//create 
$("#create").click(function (e) {
    e.preventDefault();
    var name    = $("#name").val();
    var phone   = $("#phone").val();
    var address = $("#address").val();
    var car_type_id = $("#car_type_id :selected").val();
    var model_id    = $("#model_id :selected").val();
    var year_id     = $("#year_id :selected").val();
    var contract_amount = $("#contract_amount").val();

    $.ajax({
        type:'POST',
        url: '/owner/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
            phone: phone,
            address: address,
            car_type_id: car_type_id,
            model_id: model_id,
            year_id: year_id,
            contract_amount: contract_amount,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }               
                if(response.errors.phone){
                    $('.phoneError').text(response.errors.phone);
                }               
            }else{
                $('#createModal').modal('hide');
                $("#allOwner").append('' +
                    '<tr class="owner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.phone +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td>'+ response.data.model_name +'</td>\n' +
                        '<td>'+ response.data.year_name +'</td>\n' +
                        '<td>'+ response.data.contract_amount +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-phone="'+ response.data.phone +'" data-car_type_id="'+ response.data.car_type_id +'" data-model_id="'+ response.data.model_id +'" data-year_id="'+ response.data.year_id +'" data-contract_amount="'+ response.data.contract_amount +'" data-address="'+ response.data.address +'" title="Edit">Edit</button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="'+ response.data.id +'" title="Delete">Delete</button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#phone").val('');
                toastr.success('Created.')
            }
        }
    });
});


//open edit modal
$(document).on('click', '#edit', function () {
    console.log('data phone', $(this).data('phone'))
    $('#editModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_phone').val($(this).data('phone'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
    $('#edit_model_id').val($(this).data('model_id'));
    $('#edit_year_id').val($(this).data('year_id'));
    $('#edit_contract_amount').val($(this).data('contract_amount'));
    $('#edit_address').val($(this).data('address'));
 });

// update 
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var phone   = $("#edit_phone").val();
    var car_type_id     = $("#edit_car_type_id").val();
    var model_id        = $("#edit_model_id").val();
    var year_id         = $("#edit_year_id").val();
    var contract_amount = $("#edit_contract_amount").val();
    var address         = $("#edit_address").val();
    $.ajax({
        type:'POST',
        url: '/owner/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            phone : phone,
            car_type_id : car_type_id,
            model_id    : model_id,
            year_id     : year_id,
            contract_amount : contract_amount,
            address     : address
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }
                if(response.errors.phone){
                    $('.phoneError').text(response.errors.phone);
                }   
            }else{
                $('#editModal').modal('hide');
                $("tr.owner-"+ response.data.id).replaceWith('' +
                    '<tr class="owner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.phone +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td>'+ response.data.model_name +'</td>\n' +
                        '<td>'+ response.data.year_name +'</td>\n' +
                        '<td>'+ response.data.contract_amount +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-phone="'+ response.data.phone +'" data-car_type_id="'+ response.data.car_type_id +'" data-model_id="'+ response.data.model_id +'" data-year_id="'+ response.data.year_id +'" data-contract_amount="'+ response.data.contract_amount +'" data-address="'+ response.data.address +'" title="Edit">Edit</button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="'+ response.data.id +'" title="Delete">Delete</button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Updated.')
            }
        }
    });
});

//open delete modal
$(document).on('click', '#delete', function () {
    $('#deleteModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy 
$("#destroy").click(function(){
    $.ajax({
        type: 'POST',
        url: '/owner/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteModal').modal('hide');
            $('.owner-' + $('input[name=del_id]').val()).remove();
            toastr.success('Deleted')
        }
    });
});

//open delete modal
$(document).on('click', '#sms', function () {
    $('#smsModal').modal('show');
    $('#sms_owner_id').val($(this).data('id'));
 });

//destroy 
$("#send").click(function(e){
    e.preventDefault();

    var owner_id= $('#sms_owner_id').val();
    var sms = $('#message').val();
    $.ajax({
        type: 'POST',
        url: '/owner/send-sms',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            owner_id: owner_id,
            sms: sms
        },
        success: function (data) {
            $('#smsModal').modal('hide');
            toastr.success('SMS Send Successfully')
        }
    });
});

// get car model
$("#car_type_id").change(function(){
    var car_type_id = $(this).val();
    $.get('/get-car-model/'+ car_type_id, function(response){
        $('#model_id').empty();
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
        for(var i = 0; i <= response.length; i++){
            $('#filter_model_id').append('<option value="'+ response[i].id +'">'+ response[i].name +'</option');
        }
    });
});