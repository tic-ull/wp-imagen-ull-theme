<?php global $ss_framework; ?>
<footer id="footer" class="content-info" role="contentinfo">
	<?php echo $ss_framework->open_container( 'div' );
		echo $ss_framework->open_row( 'div' );
		echo $ss_framework->open_col( 'div', array( 'mobile' => 12 ) );?>

		<ul class="address pull-left">
			<li><strong>Universidad de La Laguna</strong><br/> Pabell&oacute;n de Gobierno, C/ Molinos de Agua s/n. | San Crist&oacute;bal de La Laguna, Santa Cruz de Tenerife - Espa&#241;a (38200) | Tel&eacute;fono: (+34) 922 31 90 00</li>
		</ul>

		<ul class="list-inline text-muted pull-right">
			<li><a title="Facebook" target="_blank" href="http://www.facebook.com/universidaddelalaguna" ><span class="fa fa-facebook-square"></span></a></li>
			<li><a title="Twitter" target="_blank" href="http://twitter.com/CanalULL"><i class="fa fa-twitter-square"></i></a></li>
			<li><a title="Youtube" target="_blank" href="http://www.youtube.com/canalULL"><i class="fa fa-youtube-square"></i></a></li>
			<li><a title="LinkedIn" target="_blank" href="http://www.linkedin.com/groups/Universidad-Laguna-2656178"><i class="fa fa-linkedin-square"></i></a></li>
			<li><a title="P&aacute;gina web ULL" target="_blank" href="http://www.ull.es"><i class="fa fa-globe"></i></a></li>
		</ul>

	<?php echo $ss_framework->close_col( 'div' );
        echo $ss_framework->close_row( 'div' );
		echo $ss_framework->close_container( 'div' );?>
</footer>
