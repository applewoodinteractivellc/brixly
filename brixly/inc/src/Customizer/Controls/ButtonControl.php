<?php


namespace BrixlyWP\Theme\Customizer\Controls;


use BrixlyWP\Theme\Translations;
use WP_Customize_Manager;

class ButtonControl extends VueControl {

	public $type = 'brixly-button';

	protected function printVueContent() {
		?>
        <div class="brixly-fullwidth">
            <div class="inline-elements-container">
                <div class="inline-element fit">
                    <# if ( data.label ) { #>
                    <el-button :value="value" @click="onClick"
                               type="default">{{{ data.label }}}
                    </el-button>
                    <# } #>
                </div>
            </div>
        </div>
		<?php
	}
}
