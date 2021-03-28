$("#delete").click(function(){
    $('#deleteModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
});

$("#destroy").click(function(){
  $.ajax({
      type: 'POST',
      url: '/rent/destroy',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
        id: $('input[name=del_id]').val()
      },
      success: function (data) {
          $('#deleteModal').modal('hide');
          $('.rent-' + $('input[name=del_id]').val()).remove();
          toastr.success('Rent Deleted')
      }
  });
});