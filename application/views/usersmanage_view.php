    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>   

    <div class = "row">

      <button class="btn btn-success" onclick="add_staff()"><i class="glyphicon glyphicon-plus"></i> Add New Staff</button>
      <br />
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Authority</th>
            <th style="width:189px;">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>

        
      </table>
    </div>


  </div>


  <script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {

      
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source

        "ajax": {
          "url": "<?php echo site_url('Usersmanage/ajax_list')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });

    function add_staff()
    {
      save_method = 'add';    
      $('#form_old_password').attr("hidden", true);    
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New User'); // Set Title to Bootstrap modal title
    }

    function edit_staff(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('Usersmanage/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
         
          $('[name="id"]').val(data.userId);
          $('[name="user_name"]').val(data.name);
          $('[name="email"]').val(data.email);
          $('#form_old_password').attr("hidden", false);
          // $('[name="password"]').val(data.password);
          // $('[name="verify_password"]').val(data.password);
          $('[name="mobile"]').val(data.mobile);
          $('[name="authority"]').val(data.role);          
          $('#authority').val(data.roleId);
          
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function verify_password(password, verify)
    {
      if ( password == "" || password != verify ) {
            alert("Input correct your password");
            return false;
      }
      else 
        return true;
    }

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('Usersmanage/ajax_add')?>";
      }
      else
      {
        url = "<?php echo site_url('Usersmanage/ajax_update')?>";
      }

      $('#fName').attr("color", "black");
      if ( $('#user_name').val() == "" ) 
        $('#fName').attr("color", "red");
      
     $('#fEmail').attr("color", "black");
      if ( $('#email').val() == "" ) 
        $('#fEmail').attr("color", "red");
      
      if ( save_method == "add" ) {
          $('#fPass').attr("color", "black");
        if ( $('#password').val() == "" ) 
          $('#fPass').attr("color", "red");
        $('#fVerify').attr("color", "black");
        if ( $('#verify_password').val() == "" )
          $('#fVerify').attr("color", "red");
      }
      
      $('#fPhone').attr("color", "black");
      if ( $('#mobile').val() == "" ) 
        $('#fPhone').attr("color", "red");
      $('#fAuthority').attr("color", "black");
      if ( $('#authority').val() == "" ) 
        $('#fAuthority').attr("color", "red");

       // ajax adding data to database  
       else {    
       $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
               swal(
                'Good job!',
                'Data has been save!',
                'success'
                )
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          }); }
     }

     function is_empty()
     {

     }

     function delete_staff(id)
     {

      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      }).then(function(isConfirm) {
        if (isConfirm) {

     // ajax delete data to database
     $.ajax({
      url : "<?php echo site_url('Usersmanage/ajax_delete')?>/"+id,
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
               swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                );
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

     
   }
 })
      
    }

    function view_person(id)
{
          $.ajax({
            url : "<?php echo site_url('welcome/list_by_id')?>/" + id,
            type: "GET",
            success: function(result)
            {
                $('#haha').empty().html(result).fadeIn('slow');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert("Not correct old password");

            }
        });
      }


     //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });


  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Users Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/>  
            <input type="hidden" value="" name="old"/>
            <div class="form-body" style="margin: 30px">
              <div class="form-group">
                <font id="fName" color=""><label class="control-label col-md-3" id="lbl_name">User Name *</label></font>
                <div class="col-md-9">
                  <input id="user_name" name="user_name" placeholder="User Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <font id="fEmail" color=""><label class="control-label col-md-3" id="lbl_email">Email Address *</label></font>
                <div class="col-md-9">
                  <input id="email" name="email" placeholder="Email Address" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <font id="fPass" color=""><label class="control-label col-md-3" id="lbl_password">Password *</label></font>
                <div class="col-md-9">
                  <input id="password" name="password" placeholder="password" class="form-control" type="password">
                </div>
              </div>
              <div class="form-group">
                <font id="fVerify" color=""><label class="control-label col-md-3" id="lbl_verify">Verify Password *</label></font>
                <div class="col-md-9">
                  <input id="verify_password" name="verify_password" placeholder="verify password" class="form-control" type="password">
                </div>
              </div>
              <div class="form-group">
                <font id="fPhone" color=""><label class="control-label col-md-3" id="lbl_Phone">Phone Number *</label></font>
                <div class="col-md-9">
                  <input id="mobile" name="mobile" placeholder="Phone Number" class="form-control" type="text">
                </div>
              </div>
             <div class="form-group">
                <font id="fAuthority" color=""><label class="control-label col-md-3"  id="lbl_authority">Authority *</label></font>
                <div class="col-md-9">
                  <select name="authority" id="authority" class="form-control">
                    <option value="">Select Authority</option>
                    <option value="1">SuperAdmin</option>
                    <option value="2">Admin</option>
                    <option value="3">Manager</option>
                    <option value="4">Clients</option>
                    <option value="5">Supplier</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
</body>
</html>