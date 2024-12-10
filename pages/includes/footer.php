        <!-- jQuery -->
        <script src="assets/js/jquery-3.5.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js"></script>

		<!-- Select2 JS -->
		<script src="assets/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/dataTables.bootstrap4.min.js"></script>
		
		<!-- Chart JS -->
		<script src="assets/plugins/morris/morris.min.js"></script>
		<script src="assets/plugins/raphael/raphael.min.js"></script>
		<script src="assets/js/chart.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/app.js"></script>

		<script>
			var loadFile = function(event) {				
				var reader = new FileReader();
				reader.onload = function(){
				var output = document.getElementById('output');				
				output.src = reader.result;
				};
				reader.readAsDataURL(event.target.files[0]);
			};
			var loadFile = function(event, id_name) {
				var reader = new FileReader()
				reader.onload = function(){
				var output = document.getElementById(id_name);
				output.src = reader.result;
				};
				reader.readAsDataURL(event.target.files[0]);
			};
		</script>
		
    </body>
</html>