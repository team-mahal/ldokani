//******    Category store    ******** */ / 
$('#store').on('submit', function(event){
    event.preventDefault();
    console.log(this);
    $.ajax({
        url : $(this).attr('action'),
        method:"POST",
        data: $(this).serialize(),
        dataType:'JSON',
        success : function(response) {
            if(response == 'success'){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Create successfully!',
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

//******    Category Update    ******** *// 
$('#update').on('submit', function(event){
    event.preventDefault();
      $.ajax({
          url : $(this).attr('action'),
          method:"POST",
          data: $(this).serialize(),
          dataType:'JSON',
          success : function(response) {
              if(response == 'success'){
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Update successfully!',
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
            $("#update").attr("action", "/category/" + response.result.id);
		}
	});
}


//******    Company Find Edit Data    ******** */ / 
function find_company(id)
{
	$.ajax({
		type:"GET",
		url :"/company/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $('#description').val(response.result.description);
            $('#email').val(response.result.email);
            $('#address').val(response.result.address);
            $('#contact').val(response.result.contact);
            $("#update").attr("action", "/company/" + response.result.id);
		}
	});
}

//******    Find distributor edit data    ******** */ / 
function find_distributor(id)
{
	$.ajax({
		type:"GET",
		url :"/distributor/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $('#description').val(response.result.description);
            $('#email').val(response.result.email);
            $('#address').val(response.result.address);
            $('#contact').val(response.result.contact);
            $('#address').val(response.result.address);
            $('#balance').val(response.result.balance);
            $("#update").attr("action", "/distributor/" + response.result.id);
		}
	});
}

//******    Find unit edit data    ******** */ / 
function find_unit(id)
{
	$.ajax({
		type:"GET",
		url :"/unit/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $("#update").attr("action", "/unit/" + response.result.id);
		}
	});
}

//******    Find product edit data    ******** */ / 
function find_product(id)
{
	$.ajax({
		type:"GET",
		url :"/product/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name_edit').val(response.result.name);
            $('#category_name_edit').val(response.result.category_id);
            $('#company_name_edit').val(response.result.company_id);
            $('#unit_name_edit').val(response.result.unit_id);
            $('#barcode_edit').val(response.result.barcode);
            $('#model_edit').val(response.result.model);
            $('#size_edit').val(response.result.size);
            $('#level_edit').val(response.result.alarm_level);
            $('#genral_warranty_edit').val(response.result.warranty);
            $('#edit_id').val(response.result.id);
            $("#update").attr("action", "/product/" + response.result.id);
		}
	});
}