//******    Category store    ******** */ / 
$('#category_store').on('submit', function(event){
    event.preventDefault();
    $.ajax({
        url : '/category',
        method:"POST",
        data: $(this).serialize(),
        dataType:'JSON',
        success : function(response) {
            if(response == 'success'){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Product Create successfully!',
                    showConfirmButton: false,
                    timer: 1500
                })
                $('.bd-example-modal-lg').modal('hide');
            }else{
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'An error across',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    });
  });

  //******    Category Find Edit Data    ******** */ / 
function find_category(id)
{
	$.ajax({
		type:"GET",
		url :"/category/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
			$('#description').val(response.result.description);
			$('#id').val(response.result.id);
		}
	});
}


  //******    Category Update    ******** */ / 

$('#category_update').on('submit', function(event){
    event.preventDefault();
    var id = $('#id').val();
      $.ajax({
          url : "/category/"+id,
          method:"POST",
          data: $(this).serialize(),
          dataType:'JSON',
          success : function(response) {
              if(response == 'success'){
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Product Update successfully!',
                      showConfirmButton: false,
                      timer: 1500
                  })
                  $('.bd-update-lg').modal('hide');
              }else{
                  Swal.fire({
                      position: 'top-end',
                      icon: 'error',
                      title: 'An error across',
                      showConfirmButton: false,
                      timer: 1500
                  })
              }
          }
      });
  });