<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url().'uploads/nophoto.jpg';?>" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>RUBASRI</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
 

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>

      <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="treeview">
              <a href="#" style="text-decoration:none">
                <i class="fa fa-users"></i>
                <span >View/Edit Pupils or Staff</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li>
                <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Staff"><i class="fa fa-circle-o"></i>Staffs
                </a>
              </li>
              <li>
                <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Pupil"><i class="fa fa-circle-o"></i>Pupils
                </a>
              </li>
            </ul>
          </li>
      <li>
        <a class = "ayam" href="<?php echo base_url();?>welcome/Load_InterventionPlan"><i class="fa fa-user-md"></i>Create a New Intervention <br/>Plan
        </a>
      </li>
      <li class="treeview">
              <a href="#" style="text-decoration:none">
                <i class="fa fa-users"></i>
                <span >Register</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li>
                <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Users"><i class="fa fa-circle-o"></i>Users
                </a>
              </li>
              <li>
                <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Pupil"><i class="fa fa-circle-o"></i>Restore
                </a>
              </li>
              <li>
                <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Pupil"><i class="fa fa-circle-o"></i>Backup
                </a>
              </li>
            </ul>
          </li>
      <li>
        <a class = "ayam" href="<?php echo base_url();?>welcome/Load_Activity"><i class="fa fa-users"></i>Activities
        </a>
      </li>

      <li>
        <a class = "ayam" href="<?php echo base_url();?>welcome/load_Notes"><i class="fa fa-user-md"></i>Notes
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<script type="text/javascript">


  $(document).on('click','.ayam',function(){

   var href = $(this).attr('href');
   $('#haha').empty().load(href).fadeIn('slow');
   return false;

 });


</script>






<script type="text/javascript">

  $('.apam').removeClass('active');

</script>


<script>


  $(document).ready(function(){

    $( "body" ).on( "click", ".ayam", function() {

      $('.ayam').each(function(a){
       $( this ).removeClass('selectedclass')
     });
      $( this ).addClass('selectedclass');
    });

  })


</script>




<style type="text/css">


  li a.selectedclass
  {
    color: red !important;
    font-weight: bold;
  }

</style>