<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doRegister")?>">
		<input type="hidden" name="funcion" id="funcion" value="add"/>
		<input type="hidden" name="info" id="info" value="user_accounts"/>
        <input type="hidden" name="usuarios[activo]" value="1">
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
			</ul>
            <div class="items">
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre del usuario" class="span12" name="usuarios[nombre]" data-rule-required="true">
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label>Nivel</label>
                                <?=$nivelSelect?>
                            </div>
                        </div>
					</div>
					<div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Nombre de usuario</label>
                                <input type="text" placeholder="Nombre de usuario" class="span12" name="usuarios[usuario]"  data-rule-required="true">
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label>Contraseña</label>
                                <input type="text" placeholder="No se muestra la actual." class="span12" name="usuarios[pass]"  data-rule-required="true">
                            </div>
                        </div>
                    </div>  
                </div>
			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
            	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"usuarios"}'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>