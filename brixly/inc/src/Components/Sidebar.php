<?php
namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\View;

class Sidebar extends ComponentBase {

	public function renderContent() {
		View::partial( 'sidebar', 'post', array(
			"component" => $this,
		) );

	}

	/**
	 * @return array();
	 */
	protected static function getOptions() {
		return array();
	}
}
