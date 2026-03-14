<?php


namespace BrixlyWP\Theme\Customizer\Controls;


use BrixlyWP\Theme\Translations;

class IconControl extends VueControl {

	public $type = "brixly-icon";

	protected function printVueContent() {
		?>
			<icon-picker :value="value" :icons="icons"></icon-picker>
		<?php
	}
}
