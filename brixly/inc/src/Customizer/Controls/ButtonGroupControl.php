<?php


namespace BrixlyWP\Theme\Customizer\Controls;


use BrixlyWP\Theme\Translations;
use WP_Customize_Manager;

class ButtonGroupControl extends VueControl {

	public $type = 'brixly-button-group';

	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * @return bool|mixed
	 */
	public function getNoneValue() {
		return $this->getParam( 'none_value' );
	}

	protected function content_template() {
		$this->printVueMountPoint();

		?>
        <div class="customize-control-notifications-container"></div>
		<?php
	}

	protected function printVueContent() {
		?>
        <div class="brixly-fullwidth">
            <div class="inline-elements-container">
                <div class="inline-element">
                    <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                    <# } #>
                </div>

                <div class="inline-element fit">
                    <# if ( data.none_value ) { #>
                    <el-button @click="noneClicked"
                               type="text"><?php Translations::escHtmlE( 'none' ); ?></el-button>
                    <# } #>
                </div>
            </div>
            <brixly-group-control
                    :items="options"
                    :value="value"
                    :size="size"
                    @change="handleButtonClicked"></brixly-group-control>
        </div>
		<?php
	}
}
