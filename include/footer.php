<!-- Footer -->
<!-- Whats App button -->
<div class="whatsapp_bottom">
	<a href="https://wa.me/+9720503088409"> تواصل معنا <i class="fa fa-whatsapp"></i> </a>
</div>
<!--  Whats App Button  -->
<footer class="bg3 p-b-10" style="display:none">
	<div class="container">
		<div class="" style="padding-top: 15px;">
			<p class="stext-107 cl6 txt-center">
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				جميع الحقوق محفوظة &copy;<script>
					document.write(new Date().getFullYear());
				</script>| بواسطة <i class="fa fa-heart-o" aria-hidden="true"></i> <a href="https://wa.me/+201011642731" target="_blank">Mr</a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			</p>
		</div>
	</div>
</footer>
<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
<script src="<?php echo $js; ?>/main.js"></script>

<script>
	// JavaScript code for updating the content
	function updateStudentWin() {
		$.ajax({
			url: 'update_student_win.php', // Replace with your server script URL
			method: 'GET',
			success: function(response) {
				$('.student_win').html(response);
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	}
	// Call the updateStudentWin function every 1 second
	setInterval(updateStudentWin, 2000);
</script>
</body>

</html>