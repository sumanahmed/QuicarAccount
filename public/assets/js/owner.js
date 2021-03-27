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
        url: '/driver/store',
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
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-phone="'+ response.data.phone +'" title="Edit">Edit</button>\n' +
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


//open edit District modal
$(document).on('click', '#edit', function () {
    console.log('data phone', $(this).data('phone'))
    $('#editModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_phone').val($(this).data('phone'));
 });

// update District
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var phone   = $("#edit_phone").val();
    $.ajax({
        type:'POST',
        url: '/driver/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            phone : phone,
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
                $("tr.driver-"+ response.data.id).replaceWith('' +
                    '<tr class="driver-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.phone +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-phone="'+ response.data.phone +'" title="Edit">Edit</button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="'+ response.data.id +'" title="Delete">Delete</button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Updated.')
            }
        }
    });
});

//open delete District modal
$(document).on('click', '#delete', function () {
    $('#deleteModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy District
$("#destroy").click(function(){
    $.ajax({
        type: 'POST',
        url: '/driver/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteModal').modal('hide');
            $('.driver-' + $('input[name=del_id]').val()).remove();
            toastr.success('District Deleted')
        }
    });
});