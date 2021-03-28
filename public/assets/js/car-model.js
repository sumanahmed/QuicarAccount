//create 
$("#create").click(function (e) {
    e.preventDefault();
    var name    = $("#name").val();
    var car_type_id   = $("#car_type_id :selected").val();

    $.ajax({
        type:'POST',
        url: '/setting/car-model/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
            car_type_id: car_type_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }               
                if(response.errors.car_type_id){
                    $('.errorCarType').text(response.errors.car_type_id);
                }               
            }else{
                $('#createModal').modal('hide');
                $("#allModel").append('' +
                    '<tr class="model-'+ response.data.id +'">\n' +
                        '<td>'+ response.car_type_name +'</td>\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-car_type_id="'+ response.car_type_id +'" title="Edit">Edit</button>\n' +
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
    $('#editModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
 });

// update District
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var car_type_id   = $("#edit_car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/setting/car-model/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            car_type_id : car_type_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }
                if(response.errors.car_type_id){
                    $('.errorCarType').text(response.errors.car_type_id);
                }   
            }else{
                $('#editModal').modal('hide');
                $("tr.model-"+ response.data.id).replaceWith('' +
                    '<tr class="model-'+ response.data.id +'">\n' +
                        '<td>'+ response.car_type_name +'</td>\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-car_type_id="'+ response.car_type_id +'" title="Edit">Edit</button>\n' +
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
        url: '/setting/car-model/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteModal').modal('hide');
            $('.model-' + $('input[name=del_id]').val()).remove();
            toastr.success('District Deleted')
        }
    });
});