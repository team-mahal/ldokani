//******    Category store    ******** */ / 
$('#store').on('submit', function(event){
    event.preventDefault();
    $.ajax({
        url : $(this).attr('action'),
        method:"POST",
        data: new FormData(this),
        dataType:'JSON',
        processData: false,
        contentType: false,
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
        data: new FormData(this),
        dataType:'JSON',
        processData: false,
        contentType: false,
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

//******    Customer Find Edit Data    ******** */ / 
function find_customer(id)
{
	$.ajax({
		type:"GET",
		url :"/customer/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $('#email').val(response.result.email);
            $('#address').val(response.result.address);
            $('#contact').val(response.result.contact);
            $("#update").attr("action", "/customer/" + response.result.id);
		}
	});
}


//******    employee Find Edit Data    ******** */ / 
function find_employee(id)
{
	$.ajax({
		type:"GET",
		url :"/employee/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $('#email').val(response.result.email);
            $('#address').val(response.result.address);
            $('#contact').val(response.result.contact);
            $('#type').val(response.result.type);
            $('#balance').val(response.result.balance);
            $("#update").attr("action", "/employee/" + response.result.id);
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

//******    Company store    ******** */ / 
$('#store_company_with_product_page').on('submit', function(event){
    event.preventDefault();
    var name = $(this).find('input[name="name"]').val();
    $.ajax({
        url : $(this).attr('action'),
        method:"POST",
        data: $(this).serialize(),
        dataType:'JSON',
        success : function(response) {
            if(jQuery.isNumeric(response)){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Create successfully!',
                    showConfirmButton: false,
                    timer: 1500
                })
                var x = document.getElementById("company_name_edit");
				var option = document.createElement("option");
  				option.text = name;
				option.value = response;
				option.setAttribute("selected", "selected");
                x.add(option, x[1]);

                var y = document.getElementById("company_name");
                var option1 = document.createElement("option");
  				option1.text = name;
				option1.value = response;
				option1.setAttribute("selected", "selected");
                y.add(option1, y[1]);
                $('.company-create-modal').modal('hide');
                $(this).trigger("reset");
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


//******    Category store    ******** */ / 
$('#store_category_with_product_page').on('submit', function(event){
    event.preventDefault();
    var name = $(this).find('input[name="name"]').val();
    $.ajax({
        url : $(this).attr('action'),
        method:"POST",
        data: $(this).serialize(),
        dataType:'JSON',
        success : function(response) {
            if(jQuery.isNumeric(response)){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Create successfully!',
                    showConfirmButton: false,
                    timer: 1500
                })
                var x = document.getElementById("category_name_edit");
				var option = document.createElement("option");
  				option.text = name;
				option.value = response;
				option.setAttribute("selected", "selected");
                x.add(option, x[1]);

                var y = document.getElementById("category_name");
                var option1 = document.createElement("option");
  				option1.text = name;
				option1.value = response;
				option1.setAttribute("selected", "selected");
                y.add(option1, y[1]);
                $('.create-category').modal('hide');
                $(this).trigger("reset");
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


  
//******    Unit store    ******** */ / 
$('#store_unit_with_product_page').on('submit', function(event){
    event.preventDefault();
    var name = $(this).find('input[name="name"]').val();
    $.ajax({
        url : $(this).attr('action'),
        method:"POST",
        data: $(this).serialize(),
        dataType:'JSON',
        success : function(response) {
            if(jQuery.isNumeric(response)){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Create successfully!',
                    showConfirmButton: false,
                    timer: 1500
                })
                var x = document.getElementById("unit_name");
                var y = document.getElementById("unit_name_edit");
                $.each($(".unit_name_edit option:selected"), function () {
                    countries.push($(this).val());
                    $(this).prop('selected', false); // <-- HERE
                });
				var option = document.createElement("option");
  				option.text = name;
				option.value = response;
				option.setAttribute("selected", "selected");
                x.add(option, x[1]);
                var option1 = document.createElement("option");
  				option1.text = name;
				option1.value = response;
				option1.setAttribute("selected", "selected");
                y.add(option1, y[1]);
                $('.create-unit').modal('hide');
                $(this).trigger("reset");
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


    function GenerateUniqueID() {
        return (Math.random() * (78500000 - 78400101) + 78400101)|0;
    }
    setTimeout(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        method:"POST",
        url : "/LastProduct",
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success : function(response) {
            document.getElementById('barcode').value = response.toString()+GenerateUniqueID();
        }
    });
    }, 500);
