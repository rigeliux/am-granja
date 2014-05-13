			<div class="row-fluid no-margin">
				<div class="span12">
					<div class="box">
                    	<div class="box-head"><h4><?php echo $titulo;?></h4></div>
                        <div class="box-content box-nomargin">
                        	<form id="form1" class="form_Kool" method="post">
								<?php 
								echo $gridd[koolajax]->Render();
								echo $gridd[grid]->Render();
								?>
							</form>
                        </div>
                    </div>
                </div>
			</div>