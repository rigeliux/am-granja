<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?php echo base_url() ?>" class="sitebase">
    <title>Ancestros</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/bootstrap-ui/jquery.ui.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.admin.blue.css">
    <link rel="stylesheet" href="assets/css/bootstrap.custom.css">
    <link rel="stylesheet" href="assets/css/bootstrap.multiselect.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/jquery.jRating.css">
    <link rel="stylesheet" href="assets/css/icons.css">
    <link rel="stylesheet" href="assets/css/style.admin.css">
    <link rel="stylesheet" href="assets/css/helpers.css">
</head>
<body>
    <div id="high-cont">
    	<div id="contenido">
            <div class="items">
                <div class="clearfix"></div>
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <div class="thumbnail bg-gris">
                                <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$animal['id']?>"><?=$animal['nombre']?></a></h5>
                                <p><?=$animal['priv']?></p>
                                <p><?=$animal['reg']?></p>
                                <p><?=$animal['birth']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                    <?php if(isset($papa) && is_array($papa) && count($papa[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($papa as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>   
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($mama) && is_array($mama) && count($mama[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($mama as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="span4">
                    <?php if(isset($abuelopaterno) && is_array($abuelopaterno) && count($abuelopaterno[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($abuelopaterno as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($abuelapaterna) && is_array($abuelapaterna) && count($abuelapaterna[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($abuelapaterna as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($abuelomaterno) && is_array($abuelomaterno) && count($abuelomaterno[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($abuelomaterno as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($abuelamaterna) && is_array($abuelamaterna) && count($abuelamaterna[0])>1):?>
                        <div class="control-group">
                            <div class="<?=$thumb?>">
                                <?php foreach($abuelamaterna as $row) :?>
                                    <h5><a href="<?=site_url('admin/animales/listado/ancestros');?>/<?=$row['id']?>"><?=$row['nombre']?></a></h5>
                                    <p><?=$row['priv']?></p>
                                    <p><?=$row['reg']?></p>
                                    <p><?=$row['birth']?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
</body>