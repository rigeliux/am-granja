    <div class="outer">
		<span class="vAlign"></span>
		<div class="inner">
        	<!--<div class="logo">
	        	<img src="assets/images/logo.png">
            </div>-->
			<div class="wrap">
                <h2>Panel de Administración</h2>
                <h4>Bienvenido, ingrese sus datos</h4>
                
                <form autocomplete="off" method="post" class="validate">
                	<input type="hidden" name="redirectTo" value="<?=$this->session->flashdata('redirectTo')?>">
                    <div class="alert alert-error hide">
                        <strong>Error!</strong> Please enter an username and a password.
                    </div>
                    <div class="login">
                        <div class="email">
                            <label for="user">Usuario:</label>
                            <div class="email-input">
                                <div class="control-group">
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="fa fa-user"></i></span>
                                        <input type="text" id="usuario" name="usuario" data-rule-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pw">
                            <label for="pw">Contraseña</label>
                            <div class="pw-input">
                                <div class="control-group">
                                    <div class="input-prepend">
                                        <span class="add-on"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="password" name="password" data-rule-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit">
                        <button class="btn btn-red5">Login</button>
                    </div>
                </form>
                
            </div>
		</div>
	</div>