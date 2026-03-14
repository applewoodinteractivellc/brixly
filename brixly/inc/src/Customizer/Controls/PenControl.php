<?php


namespace BrixlyWP\Theme\Customizer\Controls;


class PenControl extends BrixlyControl {

	public $type = 'brixly-pen';

	protected function content_template() {
		?>
        <div class="control-focus"></div>
		<?php
	}
}
