    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatables_one.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/buttons.print.min.js"></script>



    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
    <div class = "row">
      <table id="descript" class="table-condensed" cellspacing="0"  border="0px" >
        <thead>
          <tr><td><font color="lightblue"><label>Name : </label></font></td>
          <td><label id="p_name"></label></td>
          <td><font color="lightblue"><label>D.O.B : </label></font></td>
          <td><label id="p_dob"></label></td>
          <td><font color="lightblue"><label>NCY : </label></font></td>
          <td><label id="p_ncy"></label></td>
          <td><font color="lightblue"><label>Level of funding : </label></font></td>
          <td><label id="p_curFunding"></label></td></tr>          
        </thead>          
      </table>
      <font color="lightblue"><label>SEN Need : </label></font>
      <label id="p_sen"></label>   
      <br />
      <a class="ayam" href="welcome/Load_InterventionPlan"><button class="btn btn-info"><i class="glyphicon glyphicon-back"></i> Back</button></a>
      <button class="btn btn-success" onclick="add_cost()"><i class="glyphicon glyphicon-plus"></i> Add Provision</button>

      <br />
      <br />
      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="width:300px;">Special Education Needs</th>
            <th>Objectives</th>
            <th>Strategies</th>
            <th style="width: 200px">cost*</th>
            <th style="width:189px;">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>        
      </table>
      <table id="total_table" class="table-condensed" cellspacing="0"  border="0px" >
        <thead>
          <tr><td style="width: 100px"><font color="red"><label>Total / </label></font></td>
<!--           <td><font color="lightblue"><label>Weekly Time : </label></font></td>
 -->          <td style="width: 150px"><label id="total_time"></label></td>
          <td><font color="lightblue"><label>Weekly Cost : </label></font></td>
          <td style="width: 150px"><label id="total_cost"></label></td>   
          <td><font color="lightblue"><label>Annum Cost : </label></font></td>
          <td style="width: 150px"><label id="annum_cost"></label></td>        
        </thead>          
      </table>
      
    </div>
  </div>


  <script type="text/javascript">

    var save_method; //for save method string
    var table;
    var staffMember;
    var maxStaff = "0";
    var maxOther = "0";
    var staffOption = "";
    var pupil_id = "<?php echo $pupil_id; ?>";
    var staff_member = <?php echo json_encode($staff_member); ?>;
    var plan_id;
    var result_cost = "";

    for (var i = 0; i < staff_member.length; i ++) {
      staffOption += "<option value='"+staff_member[i]['name']+"'>"+staff_member[i]['name']+"</option>";
    }
    
    $(document).ready(function() {
      init();
      cost_total();
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source

        "ajax": {
          "url": "<?php echo site_url('CostIndividualPlan/ajax_list')?>/" + pupil_id,
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],
         dom: 'Bfrtip',
        buttons: [
           'excel', 'pdf', 'print'
        ]

      });
    });

    function init()
    {
      $.ajax({
            url : "<?php echo site_url('InterventionPlan/ajax_edit')?>/"+pupil_id,
            type: "GET",
            dataType: "JSON",              
            success: function(data){
                // $('#p_name').val("namedfdfdf"); 
                $('#p_name').text(data.name);  
                $('#p_dob').text(data.dob);
                $('#p_ncy').text(data.ncy);
                $('#p_curFunding').text(data.cur_funding);  
                var text = "";
                var needs = ['Specific Learning Difficulty',
                'Hearing impairment','Moderate Learning Difficulty','Social, Emotional and Mental Health',
                'Severe Learning Difficulty','Physical Disability','Profound & Multiple Learning Difficuly',
                'Speech, Language and Communication Need','Multi-Sensory Impairment','Autistic Spectrum Disability',
                'Visual Impairment','Other Difficulty-Disability','No Specific Assessment','Other'];
                var temp = data.sen_needs.split(',');
                for (var i = 0; i < needs.length; i++) {     
                  if (temp[i] == "true")  {
                    if (text == "")
                        text += needs[i];
                    else
                        text += " | " + needs[i];
                  }}
                  $('#p_sen').text(text);                     
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error get data from ajax');
            }
        });

    }

    function addCost_CostIndividualPlan(id)
    {  
      plan_id = id;   
      show_cost("tbl_coststaff", "staff", "tbl_costother", "other");


    }

    function show_cost(tblname1, cost1, tblname2, cost2)
    {

      var rows = $('#tblbody_'+cost1+' tr').length;
      var rowother = $('#tblbody_'+cost2+' tr').length;
      // alert(rows);
        $.ajax({
              url : "<?php echo site_url('CostIndividualPlan/ajax_edit_cost')?>/"+plan_id+"/"+tblname1+"",
              type: "GET",
              dataType: "JSON",              
              success: function(data)
              {                
                if (rows > 0) {
                    for( var i = rows; i > 0; i -- ){                  
                      $('#tr_'+cost1+'_' + i).remove(); } 
                }
                  
                if (data.length > 0) { 
                    for (var i = 1; i <= data.length; i ++) { 
                        rows = $('#tblbody_'+cost1+' tr').length;
                        add_CostStaff(rows, "showing");
                        var n = i - 1;
                        $('[name="'+cost1+'_hour_'+i+'"]').val(data[n]['hour']);
                        $('[name="'+cost1+'_min_'+i+'"]').val(data[n]['minute']);  
                        $('[name="'+cost1+'_member_'+i+'"]').val(data[n]['staffMember']);
                        $('[name="'+cost1+'_hourly_'+i+'"]').val(data[n]['hourly']);  
                        $('[name="'+cost1+'_desc_'+i+'"]').val(data[n]['description']);
                    }
                   /*------         --------------*/
                }

                    $.ajax({
                      url : "<?php echo site_url('CostIndividualPlan/ajax_edit_cost')?>/"+plan_id+"/"+tblname2+"",
                      type: "GET",
                      dataType: "JSON",              
                      success: function(data_other){
                          if (rowother > 0) {
                          for( var i = rowother; i > 0; i -- ){                  
                          $('#tr_'+cost2+'_' + i).remove(); } 
                          }
                          if (data_other.length > 0) { 
                            for (var i = 1; i <= data_other.length; i ++) { 
                          rowother = $('#tblbody_'+cost2+' tr').length;
                          add_CostOther(rowother);
                          var n = i - 1;
                          $('[name="'+cost2+'_hour_'+i+'"]').val(data_other[n]['hour']);                          
                          $('[name="'+cost2+'_min_'+i+'"]').val(data_other[n]['minute']); 
                          $('[name="'+cost2+'_hourly_'+i+'"]').val(data_other[n]['hourly']);     
                          $('[name="'+cost2+'_member_'+i+'"]').val(data_other[n]['staffMember']); 
                          $('[name="'+cost2+'_desc_'+i+'"]').val(data_other[n]['description']);

                          }
                     /*------         --------------*/
                        }
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                        alert('Error get data from ajax');
                      }
                  });

              },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  alert('Error get data from ajax');
                }
            });

            
              $('#form_staff')[0].reset(); // reset form on modals
              $('#modal_form_cost').modal('show'); // show bootstrap modal
              $('.modal-title').text('Add Cost'); // Set Title to Bootstrap modal title

    }

    function update_cost(tblname1, cost1, tblname2, cost2)
     {   
      var result_co = "";

        var rows = $('#tblbody_'+cost1+' tr').length;
        var rowother = $('#tblbody_'+cost2+' tr').length;
        var url;
        url = "<?php echo site_url('CostIndividualPlan/ajax_cost_delete')?>/"+plan_id+"/"+tblname1;
          $.ajax({
        url : url,
        type: "POST",
        data: $('#form_staff').serialize(),
        dataType: "JSON",
        success: function(data)
        {          
          $.ajax({
          url : "<?php echo site_url('CostIndividualPlan/ajax_cost_delete')?>/"+plan_id+"/"+tblname2,
          type: "POST",
          data: $('#form_staff').serialize(),
          dataType: "JSON", 
          success: function(data)
          {  },
          error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

            /*----------         -------------*/
            var cost_annum = "";
              for (var i = 1; i <= rows; i ++) {        
              url = "<?php echo site_url('CostIndividualPlan/ajax_cost_add')?>/"+i+"/"+tblname1+"/"+plan_id+"/"+cost1;
              $.ajax({
                url : url,
                type: "POST",
                data: $('#form_staff').serialize(),
                dataType: "JSON",
                success: function(data)
                { 
                     },
                     error: function (jqXHR, textStatus, errorThrown)
                     {
                      alert('Error adding / update data');
                    }
                  });
              
              var hour = "0";
              var min = "0";
              var hourly = "0";
              if ( $('#staff_hour_'+i).val() != "" ) {
                    var text = $('#staff_hour_'+i).val() + "hours ";
                    hour = $('#staff_hour_'+i).val();
                    result_co += text; }
              if ( $('#staff_min_'+i).val() != "" ) { 
                    var text = " " + $('#staff_min_'+i).val() + "mins ";
                    min = $('#staff_min_'+i).val();
                    result_co += text;}
                    var text = $('#staff_desc_'+i).val() + "<br />";
                    result_co += text;
              if ( $('#staff_hourly_'+i).val() != "" ) {
                    hourly = $('#staff_hourly_'+i).val();}
              // if ( $('#staff_desc_'+i).val() != "" ) {

                    
                    if ( cost_annum == "" ) 
                          cost_annum = (parseFloat(hour) + ( parseFloat(min) / 60 )) * parseFloat(hourly);
                    else
                          cost_annum = parseFloat(cost_annum) + (parseFloat(hour) + ( parseFloat(min) / 60 )) * parseFloat(hourly);

                }                

////////////////
                for (var i = 1; i <= rowother; i ++) {   
              url = "<?php echo site_url('CostIndividualPlan/ajax_cost_add')?>/"+i+"/"+tblname2+"/"+plan_id+"/"+cost2;
              $.ajax({
                url : url,
                type: "POST",
                data: $('#form_staff').serialize(),
                dataType: "JSON",
                success: function(data)
                { 
                     },
                     error: function (jqXHR, textStatus, errorThrown)
                     {
                      alert('Error adding / update data');
                    }
                  });
                    var hour = "0";
                    var min = "0";
                    var hourly = "0";
                if ( $('#other_hour_'+i).val() != "" ) {
                    var text = $('#other_hour_'+i).val() + "hours";
                    hour = $('#other_hour_'+i).val();
                    result_co += text; }
                if ( $('#other_min_'+i).val() != "" ) { 
                    var text = " " + $('#other_min_'+i).val() + "mins ";
                    min = $('#other_min_'+i).val();
                    result_co += text;}
                // if ( $('#other_desc_'+i).val() != "" ) {
                    var text = $('#other_desc_'+i).val() + "<br />";
                    result_co += text;
                    if ( $('#other_hourly_'+i).val() != "" ) {
                      hourly = $('#other_hourly_'+i).val();
                    }
                    if ( cost_annum == "" ) 
                          cost_annum = (parseFloat(hour) + ( parseFloat(min) / 60 )) * parseFloat(hourly);
                    else
                          cost_annum = parseFloat(cost_annum) + (parseFloat(hour) + ( parseFloat(min) / 60 )) * parseFloat(hourly);
                    // cost_annum = parseFloat(cost_annum) * 360 / 7;
                    // text = cost_annum.toFixed(2) + " per annum";
                    // result_co += text;     

                }   
                cost_annum = parseFloat(cost_annum) * 360 / 7;
                var text = "Weekly<br />" + cost_annum.toFixed(2) + " per annum";
                result_co += text;            
              
                ////////////////////
                
                $.ajax({
                url : "<?php echo site_url('CostIndividualPlan/ajax_cost_update')?>/"+plan_id,
                data : {'value':result_co},
                type: "POST",
                dataType: "JSON",
                success: function(data)
                { 
                  reload_table();                
                  
                        
                     },
                     error: function (jqXHR, textStatus, errorThrown)
                     {
                      alert('Error adding / update data');
                    }
                  });


             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }            
          });
          $('#modal_form_cost').modal('hide');
          swal('Good job!', 'Data has been save!','success');
          //window.open('CostIndividualPlan/index/'+plan_id)

     }

     function cost_total(){

              $.ajax({
                      url : "<?php echo site_url('CostIndividualPlan/ajax_get_total')?>/"+pupil_id,
                      type: "GET",
                      dataType: "JSON",              
                      success: function(data_total){ 
                          var total_cost = ""; 
                              if (data_total.length != 0) {
                                  for ( var i = 0; i < data_total.length; i ++  )
                                  {
                                    var hour = "0";
                                    var mins = "0";
                                    var hourly = "0";
                                    if ( data_total[i]['hour'] != null && data_total[i]['hour'] != "" )
                                      hour = data_total[i]['hour'];
                                    if ( data_total[i]['minute'] != null && data_total[i]['minute'] != "" )
                                      mins = data_total[i]['minute'];
                                    if ( data_total[i]['hourly'] != null &&  data_total[i]['hourly'] != "" )
                                      hourly = data_total[i]['hourly'];
                                    var cost = ( parseFloat(hour) + (parseFloat(mins) / 60) ) * parseFloat(hourly) ;
                                    if (total_cost == "")
                                      total_cost = cost;
                                    else
                                      total_cost = parseFloat(total_cost) + parseFloat(cost);
                                      
                                  } 
                                  // alert(total_cost); 
                              }
                            
                            $.ajax({
                                    url : "<?php echo site_url('CostIndividualPlan/ajax_get_other')?>/"+pupil_id,
                                    type: "GET",
                                    dataType: "JSON",              
                                    success: function(data_other){ 
                                          if ( data_other.length != 0 ) {
                                          for ( var i = 0; i < data_other.length; i ++  )
                                          {
                                            var hour = "0";
                                            var mins = "0";
                                            var hourly = "0";
                                            if ( data_other[i]['hour'] != null && data_other[i]['hour'] != "" )
                                              hour = data_other[i]['hour'];
                                            if ( data_other[i]['minute'] != null && data_other[i]['minute'] != "" )
                                              mins = data_other[i]['minute'];
                                            if ( data_other[i]['hourly'] != null && data_other[i]['hourly'] != "" )
                                              hourly = data_other[i]['hourly'];
                                            var cost = ( parseFloat(hour) + (parseFloat(mins) / 60) ) * parseFloat(hourly) ;
                                            if (total_cost == "")
                                              total_cost = cost;
                                            else
                                              total_cost = parseFloat(total_cost) + parseFloat(cost);  

                                            $('#total_cost').text(total_cost.toFixed(2));
                                            var annum = parseFloat(total_cost) * 360 / 7;
                                            $('#annum_cost').text(annum.toFixed(2));

                                              // alert(hour + " + ( " + mins + " / 60 ) * " + hourly + " = " + total_cost);                                           
                                          } 
                                          }                                          
                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {
                                      alert('Error get data from ajax');
                                    }
                                });
                            
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                        alert('Error get data from ajax');
                      }
                  });

     }


    function add_cost()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals  

      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Cost'); // Set Title to Bootstrap modal title
    }

    function edit_CostIndividualPlan(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('CostIndividualPlan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          
          $('[name="id"]').val(data.id);
          $('[name="date"]').val(data.date); 
          $('[name="objectives"]').val(data.objectives);     
          $('[name="strategies"]').val(data.strategies);

           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Objectives or Strategies'); // Set title to Bootstrap modal ti
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
    }

    function reload_table()
    {
      cost_total();
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function save_Staff()
    {
      update_cost("tbl_coststaff", "staff", "tbl_costother", "other");  
     }

     

     function delete_CostIndividualPlan(id)
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
      url : "<?php echo site_url('CostIndividualPlan/ajax_delete')?>/"+id,
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

    function save()
    {
      var url;
      var sen = "";
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('CostIndividualPlan/ajax_add')?>/"+pupil_id;

          $.ajax({
          url : "<?php echo site_url('pupil/ajax_edit/')?>/" + pupil_id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            var needs = ['Specific Learning Difficulty',
              'Hearing impairment','Moderate Learning Difficulty','Social, Emotional and Mental Health',
              'Severe Learning Difficulty','Physical Disability','Profound & Multiple Learning Difficuly',
              'Speech, Language and Communication Need','Multi-Sensory Impairment','Autistic Spectrum Disability',
              'Visual Impairment','Other Difficulty-Disability','No Specific Assessment','Other'];
            var temp = data.sen_needs.split(',');
            for (var i = 0; i < needs.length; i++) {     
              if (temp[i] == "true")  {
                var text = needs[i] + "<br />";
                sen += text; 
              }}
                $('#sen').val(sen);
                $.ajax({
                url : url,
                type: "POST",
                data:  $('#form').serialize(),
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
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error get data from ajax');
            }
          });
      }
      else  
      {
        url = "<?php echo site_url('CostIndividualPlan/ajax_update')?>";
               $.ajax({
        url : url,
        type: "POST",
        data : {'sen':sen},
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

       // ajax adding data to database
     }

     function delete_CostIndividualPlan(id)
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
      url : "<?php echo site_url('CostIndividualPlan/ajax_delete')?>/"+id,
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

    function staffMember()
    {
      alert("123123");
    }

    function add_CostStaff(row_id, show)
    { 
      row_id ++;   
      $("#tblbody_staff").append("<tr id='tr_staff_"+row_id+"'><td width='60px'><label class='control-label'></label></td><td ><input name='staff_hour_"+row_id+"' id='staff_hour_"+row_id+"' placeholder='H' class='form-control' type='text' maxlength='2' ></td><td ><input name='staff_min_"+row_id+"' id='staff_min_"+row_id+"' placeholder='M' class='form-control' type='text' maxlength='2'></td><td><label class='control-label'>X</label></td><td ><input name='staff_hourly_"+row_id+"' id='staff_hourly_"+row_id+"' placeholder='' class='form-control' type='text' maxlength='9'></td><td><select name= 'staff_member_"+row_id+"' id= 'staff_member_"+row_id+"' class='form-control'>"+staffOption+"</select></td><td ><input name='staff_desc_"+row_id+"' id='staff_desc_"+row_id+"' placeholder='' class='form-control' type='text'></td><td ><a ><font color='lightblue' size='6px'><label class='control-label' onclick='add_CostStaff()'>+</label></font></a></td></tr>");
//      $('#staff_desc_' + maxStaff).attr("disabled", true);
      
      if (show != "showing") {
        text = $('#staff_member_'+row_id+' option:selected').text();

      $.ajax({
                          url : "<?php echo site_url('staff/ajax_member')?>/"+text,
                          type: "GET",
                          dataType: "JSON",              
                          success: function(data){
                         /*------         --------------*/                              
                              $('#staff_hourly_'+row_id).val(data.hourly_rate);   
                          },
                          error: function (jqXHR, textStatus, errorThrown)
                          {
                            alert('Error get data from ajax');
                          }
            });
      }
      
      $('#staff_member_'+row_id).change(function () {
        var SelectedText = $('option:selected',this).text();
        var SelectedValue = $('option:selected',this).val();
                    $.ajax({
                          url : "<?php echo site_url('staff/ajax_member')?>/"+SelectedText,
                          type: "GET",
                          dataType: "JSON",              
                          success: function(data){
                         /*------         --------------*/                              
                              $('#staff_hourly_'+row_id).val(data.hourly_rate);                            
                          },
                          error: function (jqXHR, textStatus, errorThrown)
                          {
                            alert('Error get data from ajax');
                          }
            });

        });
      }
      

    function add_CostOther(row_id)
    {
      row_id ++;
       $("#tblbody_other").append("<tr id='tr_other_"+row_id+"'><td width='60px'><label class='control-label'></label></td><td ><input name='other_hour_"+row_id+"' id='other_hour_"+row_id+"' placeholder='H' class='form-control' type='text' maxlength='2' ></td><td ><input name='other_min_"+row_id+"' id='other_min_"+row_id+"' placeholder='M' class='form-control' type='text' maxlength='2'></td><td><label class='control-label'>X</label></td><td ><input name='other_hourly_"+row_id+"' id='other_hourly_"+row_id+"' placeholder='' class='form-control' type='text' maxlength='5'></td><td><input name='other_member_"+row_id+"' id='other_member_"+row_id+"' placeholder='' class='form-control' type='text'></td><td ><input name='other_desc_"+row_id+"' id='other_desc_"+row_id+"' placeholder='' class='form-control' type='text'></td><td ><a ><font color='lightblue' size='6px'><label class='control-label' onclick='add_CostOther()'>+</label></font></a></td></tr>");

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
          <h3 class="modal-title">CostIndividualPlan Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <input type="hidden" value="" name="sen" id="sen"/>
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Date</label>
                <div class="col-md-9">
                  <input name="date" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Objectives</label>
                <div class="col-md-9">
                  <textarea name="objectives" placeholder="Objectives.." class="form-control"></textarea>
                </div>
              </div> 
              <div class="form-group">
                <label class="control-label col-md-3">Strategies</label>
                <div class="col-md-9">
                  <textarea name="strategies" placeholder="Strategies.." class="form-control"></textarea>
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
<!---  add cost dialog  --->
  <div class="modal fade" id="modal_form_cost" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">CostIndividualPlan Form</h3>
        </div>
        <div class="modal-header">
          <button type="button" id="btnCostS" onclick="add_CostStaff(document.getElementById('tblStaff').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length)" class="btn btn-info">Add Staff Cost</button>
          <button type="button" id = "btnCostO" class="btn btn-success" onclick="add_CostOther(document.getElementById('tblOther').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length)">Add Other Cost</button>
        </div>
        <div class="modal-body form">
          <form action="#" id="form_staff" class="form-horizontal">
            <input type="hidden" value="" name="id"/>  
            <div class="form-body">
              <div class="form-group" align="left" style="margin: 5px">

                <table id="tblStaff" class="table-condensed" cellspacing="0"  border="0px">
                  <thead>
                    <tr >  
                      <th width="100px" align="center"><label class="control-label"></label></th>
                      <th width="100px"><label class="control-label">H</label></th>
                      <th width="100px"><label class="control-label">M</label></th>
                      <th ><label class="control-label"></label></th>
                      <th width="300px"><label class="control-label"></label></th><font size="">
                      <th width="250px"><label class="control-label">Staff Member</label></th></font>
                      <th width="300px"><label class="control-label">Description</label></th>                  
                    </tr>                              
                  </thead>
                  <tbody id="tblbody_staff">                                       
                  </tbody>        
                </table>
                <table id="tblOther" class="table-condensed" cellspacing="0" border="0px">
                  <thead>
                    <tr>  
                      <th width="100px" align="center"><label class="control-label"></label></th>                    
                      <th width="100px"><label class="control-label">H</label></th>
                      <th width="100px"><label class="control-label">M</label></th>
                      <th ><label class="control-label"></label></th>
                      <th width="300px"><label class="control-label"></label></th>
                      <th width="250px"><label class="control-label">Other Cost</label></th>
                      <th width="300px"><label class="control-label" >Description</label></th>                      
                    </tr>                     
                                      
                  </thead>
                  <tbody id = "tblbody_other"> 
                                      
                  </tbody>        
                </table>                
              </div> 
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save_Staff()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
</body>
</html>

