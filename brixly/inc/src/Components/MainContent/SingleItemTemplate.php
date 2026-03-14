<?php
namespace BrixlyWP\Theme\Components\MainContent;

use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\Theme;
use BrixlyWP\Theme\View;
use BrixlyWP\Theme\Translations;

class SingleItemTemplate extends ComponentBase {

	protected static function getOptions() {
		return array();
	}

	public function renderContent() {
		if ( have_posts() ):

				View::partial( "main", "post", array(
					"component" => $this,
				) );

		else:
			View::partial( 'main', '404', array(
				"component" => $this,
			) );
		endif;
	}
}
