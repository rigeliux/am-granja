			<link rel="stylesheet" href="assets/css/error.css">
            <script src="assets/js/jquery.fittext.js"></script>
            <script>
			$(document).ready(function() {

				if($('.error').length > 0){
					$('.error').fitText(0.4);
					$('.desc').fitText(8, {minFontSize: '16px'});
				}
			});
			</script>
            <div class="error_page">
                <div class="desc">
                    No tienes el nivel para ver esta sección.
                </div>
                <div class="error">
                    403
                </div>
            </div>