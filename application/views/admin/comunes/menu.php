		<div class="navi">
			<ul class='main-nav'>
				<li class="<?=($padre=='inicio' || $padre=='') ? 'active':''?>">
					<a href="admin/" class='light'>
						<div class="ico"><i class="fa fa-home icon-white"></i></div>
						Inicio
					</a>
				</li>
				<li class="<?=($padre=='productos' ? 'active open':'')?>">
					<a href="#" class='light toggle-collapsed'>
						<div class="ico"><i class="fa fa-th-list icon-white"></i></div>
						Animales
						<span class="icono menu subnav subnav-down"></span>
					</a>
					<ul class='collapsed-nav <?=($padre=='productos' ? 'open':'closed')?>'>
						<li class="<?=(($padre=='productos' && $hijo=='listado') ? 'active':'')?>"><a href="admin/animales/listado">Listado</a></li>
					</ul>
				</li>
				<li class="<?=($padre=='usuarios') ? 'active':''?>">
					<a href="#" class='light toggle-collapsed'>
						<div class="ico"><i class="fa fa-user icon-white"></i></div>
						Usuarios
						<span class="icono menu subnav subnav-down"></span>
					</a>
					<ul class='collapsed-nav <?=($padre=='usuarios' ? 'open':'closed')?>'>
						<li class="<?=(($padre=='usuarios' && $hijo=='listado') ? 'active':'')?>"><a href="admin/usuarios/listado">Listado</a></li>
						<li class="<?=(($padre=='usuarios' && $hijo=='secciones') ? 'active':'')?>"><a href="admin/usuarios/secciones">Secciones</a></li>
						<li class="<?=(($padre=='usuarios' && $hijo=='niveles') ? 'active':'')?>"><a href="admin/usuarios/niveles">Niveles</a></li>
						<li class="<?=(($padre=='usuarios' && $hijo=='privilegios') ? 'active':'')?>"><a href="admin/usuarios/privilegios">Privilegios</a></li>
					</ul>
				</li>
			</ul>
		</div>