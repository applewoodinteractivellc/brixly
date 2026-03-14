<?php


namespace BrixlyWP\Theme\Customizer\Controls;


class SelectIconControl extends VueControl {
	public $type = 'brixly-select-icon';

	protected function printVueContent() {
		?>

        <select-with-icon
                slot="control"
                :value="value"
                @change="setValue($event)"
                :items="options"
        />

		<?php
	}
}
