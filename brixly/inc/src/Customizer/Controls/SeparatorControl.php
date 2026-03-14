<?php


namespace BrixlyWP\Theme\Customizer\Controls;

class SeparatorControl extends VueControl {

	public $type = "brixly-separator";

	protected function printVueContent() {
		?>
           <div class="separator">&nbsp;</div>
		<?php
	}
}
