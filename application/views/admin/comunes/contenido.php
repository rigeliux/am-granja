            <div class="row-fluid no-margin">
				<div class="span12">
                	<ul class="quicktasks pull-left">
                        <?php
                        foreach ($constantData['botones_l'] as $boton => $info) {
                            $href=base_url_admin($constantData['ruta'].'/'.$info['href']);
                            echo '<li><a class="'.$info['css-class'].'" href="'.$href.'" title="'.$info['text'].'">'.$info['icon'].' <span>'.$info['text'].'</span></a></li>';
                        }
                        ?>
                    </ul>
					<ul class="quicktasks pull-right">
                    	<?php
                        foreach ($constantData['botones_r'] as $boton => $info) {
                            $href=base_url_admin($constantData['ruta'].'/'.$info['href']);
                            echo '<li><a class="'.$info['css-class'].'" href="'.$href.'" title="'.$info['text'].'">'.$info['icon'].' <span>'.$info['text'].'</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
			</div>
			<?=$grid?>
            <!--<pre><?php /*print_r($constantData,true)*/ ?></pre>-->