<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
		<input type="hidden" name="funcion" id="funcion" value="edit"/>
        <input type="hidden" name="info" id="info" value="user_groups"/>
        <input type="hidden" name="nivel[id]" id="id" value="<?=$data[ugrp_id]?>"/>
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
                <li><a href="<?=$constant['site_url']?>#tabs-2">Privilegios</a></li>
			</ul>
            <div class="items">
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre del nivel" class="span12" name="nivel[nombre]" data-rule-required="true" value="<?=$data[ugrp_name]?>">
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label>Descripción</label>
                                <input type="text" placeholder="Descripción del nivel" class="span12" name="nivel[desc]" data-rule-required="true" value="<?=$data[ugrp_desc]?>">
                            </div>
                        </div>
					</div>
                    <div class="row-fluid">
                        <div class="span6">
                            <select name='nivel[admin]' class='span12' data-rule-required='true'>
                                <option value="1" <?php echo ($data[ugrp_admin] ==1)?"selected":""; ?>>Es Admin</option>
                                <option value="0" <?php echo ($data[ugrp_admin] ==0)?"selected":""; ?>>No es Admin</option>
                            </select>
                        </div>
                    </div>
					<?php //echo '<pre>'.print_r($privileges,true).'</pre>'; ?>
                </div>
                <div id="tabs-2">
                   <div class="row-fluid">
                        <div class="span12">
                            <div class="controlgroup">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                Nombre de la Sección
                                            </th>
                                            <?php foreach ($privilegios as $privilegio) : ?>
                                                <th><?=$privilegio['upriv_name'];?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?=$nivelPrivcb?>
                                    </tbody>
                                </table>
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