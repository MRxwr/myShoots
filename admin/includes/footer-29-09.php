
</div>
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- wysuhtml5 Plugin JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/wysihtml5x/dist/wysihtml5x.min.js"></script>
	
	<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/dropdown-bootstrap-extended.js"></script>
	
	<!-- Bootstrap Wysuhtml5 Init JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/bootstrap-wysuhtml5-data.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Switchery JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Init JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/init.js"></script>
    
    <!-- Bootstrap Daterangepicker JavaScript -->
		<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/dropify/dist/js/dropify.min.js"></script>
	
    <!-- Form Flie Upload Data JavaScript -->
		<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/form-file-upload-data.js"></script>
        
        	<!-- Data table JavaScript -->
	<script src="<?php echo SITEURL; ?>admin/assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo SITEURL; ?>admin/assets/style/dist/js/dataTables-data.js"></script>
     <script src="<?php echo SITEURL; ?>admin/assets/js/custom.js"></script>   
     
     
      <!-- Bootstrap Date-Picker Plugin -->
<script type= "text/javascript" src= "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel= "stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script type="text/javascript">
$(document).ready(function(){
$("#datepicker").datepicker();
});
</script>
   
   <script src="<?php echo SITEURL; ?>admin/assets/js/mdtimepicker.js"></script>
<script>
  $(document).ready(function(){
    $('.timepicker').mdtimepicker(); //Initializes the time picker
	$('.timepicker1').mdtimepicker();
  });
</script>  

   <script type="text/javascript">//<![CDATA[


var i = 0;

$(document).on('click','.delete', function(e) {
   $(this).closest('.form-group-delete').remove();//remove
	--i;
	console.log('removed');
});

$(document).on('click','.timepicker', function(e) {
   $(this).closest('.timepicker').mdtimepicker();//remove
});

$('#comm').click(function(){
if (i <=3){	
$('<div class="row form-group-delete" ><div class="col-sm-4"><label class="control-label mb-10 text-left"><?php echo $lang['start_time'] ?></label><div class="form-group"><div class="input-group"><input type="text" class="form-control timepicker" name="sDate" data-name="startDate" value="" autocomplete="off"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></div></div><div class="col-sm-4"><label class="control-label mb-10 text-left"><?php echo $lang['end_time'] ?></label><div class="form-group"><div class="input-group"><input type="text" class="form-control timepicker" name="eDate"  data-name="endDate" value="" autocomplete="off"/><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></div></div><div class="col-sm-4"><button type="button" class="btn-primary btn-sm delete" id="minusButton"><?php echo $lang['delete'] ?></button></div></div>').appendTo('#email');
i++; }

});

$(function () { 
    $(document).on('click', '#submit', function (e) {
		
        var dataGroup = [];
        $('.form-group-delete').each(function () {
            var emailData = {};
            $(this).find(':input[data-name]').each(function () {
                emailData[$(this).data('name')] = $(this).val();
				//console.log($(this).val());
				//console.log(emailData);
            });
            dataGroup.push(emailData);
        });      
       // console.log(dataGroup);
               $('#alltime').val(JSON.stringify(dataGroup))
    });

})



  //]]></script>  
</body>

</html>
