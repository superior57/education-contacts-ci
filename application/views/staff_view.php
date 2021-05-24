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
            <th>Position</th>
            <th>Hourly Rate</th>
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

      $('#chbPortal').change(function(){
        var check = document.getElementById("chbPortal").checked;
        $('#userName').attr("disabled", !check); 
        $('#password').attr("disabled", !check);
        $('#chbAdmin').attr("disabled", !check);
        $('#chbAdmin').attr("checked", false);
     });
      

      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('Staff/ajax_list')?>",
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
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New Teacher'); // Set Title to Bootstrap modal title
      var check = document.getElementById("chbPortal").checked;
        $('#userName').attr("disabled", !check); 
        $('#password').attr("disabled", !check);
        $('#chbAdmin').attr("disabled", !check);
        $('#chbAdmin').attr("checked", false);
    }

    function edit_staff(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('staff/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
         
          $('[name="id"]').val(data.id);
          $('[name="name"]').val(data.name);
          $('[name="position"]').val(data.position);
          $('[name="hourly_rate"]').val(data.hourly_rate);
          $('[name="notes"]').val(data.notes);
          if (data.is_portalLogon == "on"){
           $('[name="chbPortal"]').attr("checked", true);  
           $('[name="userName"]').attr("disabled", false);       
           $('[name="password"]').attr("disabled", false);            
          }
          else
           $('[name="chbPortal"]').attr("checked", false); 
          $('[name="userName"]').val(data.userName);       
          $('[name="password"]').val(data.password);
          if (data.is_adminAccess == "on"){
            $('[name="chbAdmin"]').attr("checked", true);
            $('[name="chbAdmin"]').attr("disabled", false);
          }
          else
            $('[name="chbAdmin"]').attr("checked", false);
          
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Teacher'); // Set title to Bootstrap modal title
            
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

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('staff/ajax_add')?>";
      }
      else
      {
        url = "<?php echo site_url('staff/ajax_update')?>";
      }



       // ajax adding data to database
       $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
                if ( $('#chbPortal').is(":checked") ) {
                  $('#status').val("1");
                  $('#Admin').val("5");
                  if ($('#Admin').is(":checked"))
                    $('#Admin').val("2");
                    $.ajax({
                      url : "<?php echo site_url('Usersmanage/ajax_staff_add')?>",
                      type: "POST",
                      data: $('#form').serialize(),
                      dataType: "JSON",
                      success: function(data)
                      {},error: function (jqXHR, textStatus, errorThrown)
                       {
                        alert('Error adding / update data123');
                      }
                    });
                        }
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
          });
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
      url : "<?php echo site_url('staff/ajax_delete')?>/"+id,
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
          <h3 class="modal-title">Staff Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <input type="hidden" value="" name="Admin"/> 
            <input type="hidden" value="" name="status"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input id="name" name="name" placeholder="Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Position</label>
                <div class="col-md-9">
                  <input id="position" name="position" placeholder="Position" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Hourly Rate</label>
                <div class="col-md-9">
                  <input id="hourly_rate" name="hourly_rate" placeholder="Hourly Rate" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Notes</label>
                <div class="col-md-9">
                  <textarea id="notes" name="notes" placeholder="Notes.." class="form-control"></textarea>
                </div>
              </div>              
              <div class="form-group">                
                <div class="col-md-9"><label class="m-checkbox  m-checkbox--light">
                      <input type="checkbox" id="chbPortal" name="chbPortal">Portal Logon                    
                    </label>
                </div>                    
              </div>
              <div class="form-group" >
                <label class="control-label col-md-3">Email Address</label>
                <div class="col-md-9">
                  <input  id="userName" name="userName" placeholder="Username" class="form-control" type="text" disabled="true">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Password</label>
                <div class="col-md-9">
                  <input id="password" name="password" placeholder="Password" class="form-control" type="password" disabled="true">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-md-3"></label>               
                <div class="col-md-9"><label class="m-checkbox  m-checkbox--light">
                      <input type="checkbox" name="chbAdmin" id="chbAdmin" disabled="true">Admin access                   
                    </label>
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