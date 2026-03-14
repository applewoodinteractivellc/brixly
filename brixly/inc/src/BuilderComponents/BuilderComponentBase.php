<?php
/**
 * Created by PhpStorm.
 * User: yupal
 * Date: 2/11/2019
 * Time: 10:55 AM
 */

namespace BrixlyWP\Theme\BuilderComponents;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Core\Hooks;
use function ExtendBuilder\brixly_output_dynamic_template;

abstract class BuilderComponentBase extends ComponentBase {

	/**
	 * @return string
	 */
	protected abstract function getName();


	public function render( $parameters = array() ) {
		$template_type = Hooks::brixly_apply_filters( "{$this->getName()}_partial_type", "" );
		brixly_output_dynamic_template( $template_type, $this->getName() );
	}

	public function renderContent() {

	}

	/**
	 * @return array();
	 */
	protected static function getOptions() {
		return array();
	}
}
