<?php
global $ss_settings;

$navbar_toggle = $ss_settings['navbar_toggle'];

if ( $navbar_toggle != 'none' ) {?>
	<header id="banner-header-ull" class="banner <?php echo apply_filters( 'shoestrap_navbar_class', 'navbar navbar-default', 'ull-bar' ); ?>" role="banner">
		<div class="<?php echo apply_filters( 'shoestrap_navbar_container_class', 'container' ); ?>">
			<div class="navbar-header">
				<a class="navbar-brand text" href="http://www.ull.es/">Universidad de La Laguna</a>
			</div>
			<nav class="nav-main navbar-collapse collapse" role="navigation">
				<ul class="<?php echo apply_filters( 'shoestrap_nav_class', 'navbar-nav nav' ); ?>">
					<li class="dropdown"><a title="Servicios telemáticos" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Servicios telemáticos <span class="caret"></span></a>
						<ul role="menu" class="dropdown-menu">
							<li><a target="_blank" title="Gestión de perfil de usuario" href="http://usuarios.ull.es/"><i class="fa fa-user"></i> Gestión de perfil de usuario</a></li>
							<li><a target="_blank" title="Portal" href="http://portal.ull.es/"><i class="fa fa-folder-open"></i> Portal</a></li>
							<li><a target="_blank" title="Sede electrónica" href="http://sede.ull.es/"><i class="fa fa-briefcase"></i> Sede electrónica</a></li>
							<li><a target="_blank" title="Campus virtual" href="http://www.campusvirtual.ull.es/"><i class="fa fa-pencil"></i> Campus virtual</a></li>
							<li><a target="_blank" title="Correo electrónico" href="http://ull.edu.es/"><i class="fa fa-envelope"></i> Correo electrónico</a></li>
							<li><a target="_blank" title="Disco duro virtual" href="http://ddv.ull.es/"><i class="fa fa-hdd-o"></i> Disco duro virtual</a></li>
							<li><a target="_blank" title="Biblioteca digital" href="http://www.bbtk.ull.es/view/institucional/bbtk/Biblioteca_Digital/es"><i class="fa fa-book"></i> Biblioteca digital</a></li>
							<li><a target="_blank" title="Eventos" href="http://eventos.ull.es/"><i class="fa fa-calendar"></i> Eventos</a></li>
						</ul>
					</li>
					<li class="dropdown"><a title="Contacto" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Contacto <span class="caret"></span></a>
						<ul role="menu" class="dropdown-menu">
							<li><a target="_blank" title="Página Web ULL" href="http://www.ull.es/"><i class="fa fa-envelope"></i> Página Web ULL</a></li>
							<li><a target="_blank" title="Formulario de contacto" href="http://www.ull.es/view/institucional/ull/Contacto_3/es"><i class="fa fa-globe"></i> Formulario de contacto</a></li>
							<li><a target="_blank" title="Directorio telefónico" href="http://www.ull.es/view/institucional/ull/Telefonos/es"><i class="fa fa-phone"></i> Directorio telefónico</a></li>
							<li class="divider"></li>
							<li>
								<ul class="rrss text-muted list-inline">
									<li><a target="_blank" href="http://www.facebook.com/universidaddelalaguna"><i class="fa fa-facebook-square"></i></a></li>
									<li><a target="_blank" href="http://www.tuenti.com/#m=Page&amp;func=index&amp;page_key=1_160_68944913"><i class="fa fa-tumblr-square"></i></a></li>
									<li><a target="_blank" href="http://twitter.com/CanalULL"><i class="fa fa-twitter-square"></i></a></li>
									<li><a target="_blank" href="http://www.linkedin.com/groups/Universidad-Laguna-2656178"><i class="fa fa-linkedin-square"></i></a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</header>

<?php
} else {
	return '';
}
