<!--untuk penutup container--></div> 
</div>
<!--untuk penutup container-->
</body>
 <script src="tema/assets/js/jquery.min.js"></script>
  
<script src="tema/data/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="tema/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="tema/js/dataTables.select.min.js" type="text/javascript"></script>
<script src="tema/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="tema/js/jszip.min.js" type="text/javascript"></script>
<script src="tema/js/pdfmake.min.js" type="text/javascript"></script>
<script src="tema/js/vfs_fonts.js" type="text/javascript"></script>
<script src="tema/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="tema/js/buttons.print.min.js" type="text/javascript"></script>
<script src="tema/js/buttons.colVis.min.js" type="text/javascript"></script>

<script src="tema/js/demo.js" type="text/javascript"></script> 
 <script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').DataTable( {
		dom: 'Bfrtip', 
		buttons: [ 			
		], 
		 columnDefs: [ {
            targets: -1,
            visible: false
        } ],
	} );
} );



	</script>
    
<script type="text/javascript">

 $(document).ready(function(){
    $('#example').DataTable();
});
</script> 
  <script src="tema/datepicker/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker2" ).datepicker();
	 $( "#datepicker" ).change(function() {
             $( "#datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd" );
         });
	 $( "#datepicker2" ).change(function() {
             $( "#datepicker2" ).datepicker( "option", "dateFormat","yy-mm-dd" );
         });
  } );
  </script>
    <script>window.jQuery || document.write('<script src="tema/assets/js/jquery.min.js"><\/script>')</script>
    <script src="tema/dist/js/bootstrap.min.js"></script>
    <script src="tema/assets/js/docs.min.js"></script>
</html>