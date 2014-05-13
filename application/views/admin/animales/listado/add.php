<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doRegister")?>">
		<input type="hidden" name="funcion" id="funcion" value="add"/>
		<input type="hidden" name="info" id="info" value="animal_listado"/>
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
                <li><a href="<?=$constant['site_url']?>#tabs-2">Fotos</a></li>
			</ul>
            <div class="items">
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre" class="span12" name="animal[nombre]" data-rule-required="true">
                            </div>
                        </div>
                         <div class="span4">
                            <div class="control-group">
                                <label>Número privado</label>
                                <input type="text" placeholder="Número privado" class="span12" name="animal[priv]" data-rule-required="true">
                            </div>
                        </div>
                         <div class="span4">
                            <div class="control-group">
                                <label>birth</label>
                                <input type="date" class="span12 fecha" name="animal[birth]" data-rule-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Número de registro</label>
                                <input type="text" class="span12" name="animal[reg]" placeholder="Número de registro" data-rule-required="true">
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label>Sexo</label>
                                 <select name="animal[sexo]" data-rule-required="true">
                                    <option></option>
                                    <option value="macho">Macho</option>
                                    <option value="hembra">Hembra</option>
                                </select>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label>Raza</label>
                                <input type="text" class="span12" name="animal[raza]" placeholder="Raza" data-rule-required="true">
                            </div>
                        </div>
					</div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Padre</label>
                                <select name="animal[padre]" data-rule-required="true">
                                    <option></option>
                                    <?=$getPadreListado?>
                                </select>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label>Madre</label>
                                <select name="animal[madre]" data-rule-required="true">
                                    <option></option>
                                    <?=$getMadreListado?>
                                </select>
                            </div>
                        </div>
                         <div class="span4">
                            <div class="control-group">
                                <label>Propio</label>
                                <select name="animal[propio]" data-rule-required="true">
                                    <option></option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Activo</label>
                                <select name="animal[activo]" data-rule-required="true">
                                    <option></option>
                                    <option value="1">Activo</option>
                                    <option value="0">No Activo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-2">
                </div>
			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
            	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"listado"}'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>