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

      <button class="btn btn-success" onclick="add_pupil()"><i class="glyphicon glyphicon-plus"></i> Add New Pupil</button>
      <br />
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>DOB</th>
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

      $('#is_fsmY').change(function(){
        var check = document.getElementById("is_fsmY").checked;
        $('#is_fsmN').attr("checked", !check);
     });
      $('#is_ealY').change(function(){
        var check = document.getElementById("is_ealY").checked;
        $('#is_ealN').attr("checked", !check);
     });
      $('#is_fsmN').change(function(){
        var check = document.getElementById("is_fsmN").checked;
        $('#is_fsmY').attr("checked", !check);
     });
      $('#is_ealN').change(function(){
        var check = document.getElementById("is_ealN").checked;
        $('#is_ealY').attr("checked", !check);
     });

      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('pupil/ajax_list')?>",
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

    function add_pupil()
    {
      check_clear();

      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New Pupil'); // Set Title to Bootstrap modal title
    }

    function edit_pupil(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('pupil/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          
          $('[name="id"]').val(data.id);
          $('[name="name"]').val(data.name);
          $('[name="dob"]').val(data.dob);
          
          if (data.is_fsm == "on"|data.is_fsm == "true"|data.is_fsm == "1") {
            $('[id="is_fsmY"]').attr("checked", true); 
            $('[id="is_fsmN"]').attr("checked", false);
          } else {
            $('[id="is_fsmY"]').attr("checked", false); 
            $('[id="is_fsmN"]').attr("checked", true);
          }
          if (data.is_eal == "on"|data.is_eal == "true"|data.is_eal == "1") {
            $('[id="is_ealY"]').attr("checked", true); 
            $('[id="is_ealN"]').attr("checked", false);
          } else {
            $('[id="is_ealY"]').attr("checked", false); 
            $('[id="is_ealN"]').attr("checked", true);
          }
          $('[name="ncy"]').val(data.ncy);   
          $('[name="sen_status"]').val(data.sen_status);       
          $('[name="cur_funding"]').val(data.cur_funding);
          $('[name="upn"]').val(data.upn);          
          $('[name="notes"]').val(data.notes);
          $('[name="sen_needs"]').val(data.sen_needs);

          var needs = ['chb_specific',
            'chb_hear','chb_moderate','chb_social','chb_severe','chb_physical','chb_profound','chb_speech','chb_multi','chb_autistic','chb_visual','chb_other_dif','chb_no_specific','chb_other'];
          var temp = data.sen_needs.split(',');
          for (var i = 0; i < needs.length; i++) {   
            console.log(needs[i] + "====" + temp[i]);  
            if (temp[i] == "true")       
              $('#' + needs[i]).attr("checked", true);
            else
              $('#' + needs[i]).attr("checked", false);
          }          
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Pupil'); // Set title to Bootstrap modal title
            
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

    function check_clear()
    {
      $('#is_fsmY').attr("checked", false);
      $('#is_fsmN').attr("checked", false);
      $('#is_ealY').attr("checked", false);
      $('#is_ealN').attr("checked", false);

      var needs = ['chb_specific',
            'chb_hear','chb_moderate','chb_social','chb_severe','chb_physical','chb_profound','chb_speech','chb_multi','chb_autistic','chb_visual','chb_other_dif','chb_no_specific','chb_other'];
          
      for (var i = 0; i < needs.length; i++) {
        $('#' + needs[i]).attr("checked", false);
      }
    }


    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('pupil/ajax_add')?>";
      }
      else
      {
        url = "<?php echo site_url('pupil/ajax_update')?>";
      }
      var temp=['chb_specific',
      'chb_hear','chb_moderate','chb_social','chb_severe','chb_physical','chb_profound','chb_speech','chb_multi','chb_autistic','chb_visual','chb_other_dif','chb_no_specific','chb_other'];
      var test="";
      for(var i=0; i<temp.length; i++){
        if(i==0){
          test=document.getElementById(temp[i]).checked;
        }else {
          test+=","+document.getElementById(temp[i]).checked;
        }
      }
      $('#sen_needs').val(test);
       // ajax adding data to database
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
          });
     }

     function delete_pupil(id)
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
      url : "<?php echo site_url('pupil/ajax_delete')?>/"+id,
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
  <div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Pupil Form</h3>
        </div>
        <div class="modal-body">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group" align="center">
                <div style="margin: 10px;">
                <font size="2px">
                <table border="0px" >
                  <thead>
                    <th></th> 
                    <th></th>                   
                  </thead>
                  <tbody>
                    <tr>
                      <td><table>
                            <tr><td><table><tr><td><input name="name" placeholder="Name" class="form-control" type="text"></td><td><label class="control-label col-md-3">Name</label></td></tr>
                            <tr><td><input name="dob" id="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text"></td><td><label class="control-label col-md-3">DOB</label></td></tr></table></td></tr><tr>
                            <td><table><tr><td><label class="control-label col-md-3">FSM/EVER6</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="is_fsmY" id="is_fsmY">Yes</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="is_fsmN" id="is_fsmN">No</label></td></tr><tr><td><label class="control-label col-md-3">EAL</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="is_ealY" id="is_ealY">Yes</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="is_ealN" id="is_ealN">No</label></td></tr></table></td>
                          </tr>
                        </table>
                      </td> 
                      <td><table border="0px" height = ""><tr><td><label class="control-label col-md-3">Notes</label></td></tr><tr><td><textarea name="notes" id="notes" placeholder="Notes.." class="form-control" cols="50" rows="5"></textarea></td></tr></table></td>             
                    </tr>
                    <tr><td><table><tr><td><select name="ncy" id="ncy" class="form-control">
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select></td><td><label class="control-label col-md-3">NCY</label></td></tr>
                        <tr><td><select name="sen_status" id="sen_status" class="form-control">
                        <option value="No">No</option>
                        <option value="SEN">SEN</option>
                        <option value="WATCH List">WATCH List</option>
                        <option value="SEN Support">SEN Support</option>
                        <option value="EHCP">EHCP</option>
                        <option value="SEN School">SEN School</option>
                      </select></td><td><label class="control-label col-md-3">SEN STATUS</label></td></tr>
                        <tr><td><select name="cur_funding" id="cur_funding" class="form-control">
                        <option value="EHCP">EHCP</option>
                        <option value="Applying for EHCP">Applying for EHCP</option>
                        <option value="SEN School">SEN School</option>
                      </select></td><td><font size="1px"><label class="control-label col-md-3">Current LevelOf Funding</label></font></td></tr>
                        <tr><td><input name="upn" id="upn" placeholder="UPN" class="form-control" type="text"></td><td><label class="control-label col-md-3">UPN</label></td></tr></table></td>
                        <font size="1px"><td><table><tr><td><label class="control-label col-md-3">SENNEEDS</label></td></tr><tr><td><label class="m-checkbox  m-checkbox--light">
                      <input type="checkbox" name="chb_specific" id="chb_specific">Specific Learning Difficulty</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_hear" id="chb_hear">Hearing impairment</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_moderate" id="chb_moderate">Moderate Learning Difficulty</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_social" id="chb_social">Social, Emotional and Mental Health</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_severe" id="chb_severe">Severe Learning Difficulty</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_physical" id="chb_physical">Physical Disability</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_profound" id="chb_profound">Profound & Multiple Learning Difficuly</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_other_dif" id="chb_other_dif">Other Difficulty-Disability</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light">
                      <input type="checkbox" name="chb_speech" id="chb_speech">Speech, Language and Communication Need</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_multi" id="chb_multi">Multi-Sensory Impairment</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_autistic" id="chb_autistic">Autistic Spectrum Disability</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_no_specific" id="chb_no_specific">No Specific Assessment</label></td></tr>
                        <tr><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_visual" id="chb_visual">Visual Impairment</label></td><td><label class="m-checkbox  m-checkbox--light"><input type="checkbox" name="chb_other" id="chb_other">Other</label></td></tr></table></td> </font>        
                    </tr>
                  </tbody>
                </table></font></div>
                <input type="text" name="sen_needs" id="sen_needs" hidden="true">
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