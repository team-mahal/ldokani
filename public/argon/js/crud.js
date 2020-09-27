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



//******    bank Find Edit Data    ******** */ / 
function find_bank(id)
{
	$.ajax({
		type:"GET",
		url :"/bankentry/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $('#account_no').val(response.result.account_no);
            $('#account_name').val(response.result.account_name);
            $('#description').val(response.result.description);
            $("#update").attr("action", "/bankentry/" + response.result.id);
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

//******    Find unit edit data    ******** */ / 
function find_card(id)
{
	$.ajax({
		type:"GET",
		url :"/card/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#name').val(response.result.name);
            $("#update").attr("action", "/card/" + response.result.id);
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



//******    Find expense edit data    ******** */ / 
function find_expense(id)
{
	$.ajax({
		type:"GET",
		url :"/expense/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#type_id_edit').val(response.result.type_id);
            $('#provider_id_edit').val(response.result.provider_id);
            $('#employee_id_edit').val(response.result.employee_id);
            $('#amount_edit').val(response.result.amount);
            $('#paid_amount_edit').val(response.result.paid_amount);
            $('#details_edit').val(response.result.details);
            $('#mode_edit').val(response.result.mode);
            
            if(response.result.mode == 2){
                $('#cheque_edit').show();
                $('#bank_edit').val(response.cheque.bank_id);
                $('#cheque_no_edit').val(response.cheque.cheque_no);
                $('#date_edit').val(response.cheque.date);
                console.log(response);
            }else if(response.result.mode == 3)
            {
                $('#card_edit1').show();
                $('#card_edit').val(response.result.mode_type_id);
            }
            $("#update").attr("action", "/expense/" + response.result.id);
		}
	});
}



//******    Find income edit data    ******** */ / 
function find_income(id)
{
	$.ajax({
		type:"GET",
		url :"/income/"+id+"/edit",
		data : {},
		success : function(response) {
			$('#type_id_edit').val(response.result.type_id);
            $('#provider_id_edit').val(response.result.provider_id);
            $('#amount_edit').val(response.result.amount);
            $('#paid_amount_edit').val(response.result.paid_amount);
            $('#details_edit').val(response.result.details);
            $('#mode_edit').val(response.result.mode);
            
            if(response.result.mode == 2){
                $('#cheque_edit').show();
                $('#bank_edit').val(response.cheque.bank_id);
                $('#cheque_no_edit').val(response.cheque.cheque_no);
                $('#date_edit').val(response.cheque.date);
                console.log(response);
            }else if(response.result.mode == 3)
            {
                $('#card_edit1').show();
                $('#card_edit').val(response.result.mode_type_id);
            }
            $("#update").attr("action", "/income/" + response.result.id);
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


//******    employee store    ******** */ / 
$('#store_employee_with_expense_page').on('submit', function(event){
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
                var x = document.getElementById("employee_id");
                var y = document.getElementById("employee_id_edit");
                $.each($(".employee_id_edit option:selected"), function () {
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
                $('.employee-create').modal('hide');
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
$('#store_type_with_expense_page').on('submit', function(event){
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
                var x = document.getElementById("type_id");
                var y = document.getElementById("type_id_edit");
                $.each($(".type_id_edit option:selected"), function () {
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
                $('.create-type').modal('hide');
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

  

  //******    serviceprovider store    ******** */ / 
$('#store_serviceprovider_with_expense_page').on('submit', function(event){
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
                var x = document.getElementById("serviceprovider_id");
                var y = document.getElementById("provider_id_edit");
                $.each($("#provider_id_edit option:selected"), function () {
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
                $('.provider-create').modal('hide');
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

  function showDiv(value){
    if(value==2){
        $('#cheque').show();
        $('#card').hide();
    }else if(value==3){
        $('#cheque').hide();
        $('#card').show();
    }else{
        $('#cheque').hide();
        $('#card').hide();
    }
}

function showDivEdit(value){
    if(value==2){
        $('#cheque_edit').show();
        $('#card_edit1').hide();
    }else if(value==3){
        $('#cheque_edit').hide();
        $('#card_edit1').show();
    }else{
        $('#cheque_edit').hide();
        $('#card_edit1').hide();
    }
}


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

$("#date").flatpickr({
    wrap: true,
    dateFormat: "Y-m-d",
});
$("#date1").flatpickr({
    wrap: true,
    dateFormat: "Y-m-d",
});
