$(function () {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var table = $('#tClient').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/client/new',
      type: "GET"
    },
    columns: [
      { data: 'client_id', name: 'client_id' },
      { data: 'first_name', name: 'first_name' },
      { data: 'last_name', name: 'last_name' },
      { data: 'email', name: 'email' },
      { data: 'address', name: 'address' },
      { data: 'phone', name: 'phone' },
      {
        data: 'photo',        
        render: function (data, type, row, meta) {
          var imgsrc = 'data:image/png;jpg;gif;jpeg;svg;base64,' + data;
          return '<img class="img-responsive" src="' + imgsrc + '" alt="tbl_StaffImage" height="100px" width="100px">';
        }
      },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]

  });


  var table2 = $('#tTravel').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '/getTravel',
      type: "GET"
    },
    columns: [
      { data: 'client_id', name: 'client_id' },
      { data: 'first_name', name: 'first_name' },
      { data: 'last_name', name: 'last_name' },
      { data: 'email', name: 'email' },
      { data: 'phone', name: 'phone' },
      { data: 'travel_date', name: 'travel_date' },
      { data: 'country', name: 'country' },
      { data: 'city', name: 'city' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
  });

  $('body').on('click', '.editClient', function () {
    var client_id = $(this).data('id');
    $.get('/client/' + client_id + '/edit', function (data) {
      $('#modelHeading').html("Edit Product");
      $('#saveBtn').val("edit-user");
      $('#ajaxModel').modal('show');
      $('#client_id').val(data.client_id);
      $('#first_name').val(data.first_name);
      $('#last_name').val(data.last_name);
      $('#email').val(data.email);
      $('#address').val(data.address);
      $('#phone').val(data.phone);
    })
  });

  $('#saveBtn').click(function (e) {
    e.preventDefault();
    var formData = new FormData(); // Currently empty    
    formData.append('client_id', $("#client_id").val());
    formData.append('first_name', $("#first_name").val());
    formData.append('last_name', $("#last_name").val());
    formData.append('email', $("#email").val());
    formData.append('phone', $("#phone").val());
    formData.append('address', $("#address").val());
    formData.append("photo", $("#photo")[0].files[0]);
    $(this).html('SAVE CHANGES');
    $.ajax({
      data: formData,
      processData: false, 
      contentType: false, 
      url: '/client/update',
      type: "POST",
      dataType: 'json',
      success: function (data) {
        $('#productForm').trigger("reset");
        $('#ajaxModel').modal('hide');
        table.draw();
        alert('Client information were updated succesfully');
      },
      error: function (data) {
        $('#productForm').trigger("reset");
        $('#ajaxModel').modal('hide');             
        table.draw();        
      }
    });
  });

  $('body').on('click', '.deleteClient', function () {
    var client_id = $(this).data("id");
    var opcion = confirm("Are you sure do you want to delete the client?. Will be delete his personal information and travels.");
    if (opcion == true) {
      $.ajax({
        type: "POST",
        url: "/travel/delete/" + client_id,
        success: function (data) {
          alert('Client deleted Succesfully')
          table2.draw();
          table.draw();
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    } else {

    }

  });

});