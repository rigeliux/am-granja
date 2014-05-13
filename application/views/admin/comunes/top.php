<!doctype html>
<html>
<head>
<meta charset="utf-8">
<base href="<?php echo base_url() ?>" class="sitebase">
<title><?=$titulo.$siteName?></title>
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
<?php echo registred_css($css); ?>

</head>
<body>
<div id="hs-source"><div class="load-async-cont"></div></div>
<div class="loading first-loading" style="width:100%; height:100%;"></div>
<div class="topbar">
	<div class="container-fluid">
		<a href="index.php" class='company'>Panel de administración</a>
		<ul class='mini'>
			<!--<li class='dropdown messageContainer'>
				<a href="#" class='dropdown-toggle' data-toggle='dropdown'>
					<img src="img/icons/fugue/balloons-white.png" alt="">
					Mensajes
					<span class="label label-info">3</span>
				</a>
				<ul class="dropdown-menu pull-right custom custom-dark">
					<li class='custom'>
						<div class="title">
							Hello, whats your name?
							<span>Jul 22, 2012 by <a href="#" class='pover' data-title="Hover me" data-trigger="hover" data-placement="bottom" data-content="User information comes here">Hover me</a></span>
						</div>
						<div class="action">
							<div class="btn-group">
								<a href="#" class='tip btn btn-mini' title="Show message"><img src="img/icons/fugue/magnifier.png" alt=""></a>
								<a href="#" class='tip btn btn-mini' title="Reply message"><img src="img/icons/fugue/mail-reply.png" alt=""></a>
							</div>
						</div>
					</li>
				</ul>
			</li>
			<li> <a href="#"> <img src="img/icons/fugue/gear.png" alt=""> Configuración </a> </li>-->
			<li> <a href="#" rel="nofollow" class="logout"><img src="assets/images/icons/fugue/control-power.png" alt=""> Salir</a> </li>
		</ul>
	</div>
</div>

<div class="breadcrumbs">
	<div class="container-fluid">
    	<?=set_breadcrumb()?>
	</div>
</div>
<div class="main">
	<div class="container-fluid">
		<?=$menu?>
        <div class="content">
			