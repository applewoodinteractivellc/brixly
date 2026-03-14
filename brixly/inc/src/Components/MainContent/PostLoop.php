<?php
namespace BrixlyWP\Theme\Components\MainContent;

use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\Theme;
use BrixlyWP\Theme\View;
use BrixlyWP\Theme\Translations;

class PostLoop extends ComponentBase {

	protected static function getOptions() {
		return array();
	}

	public function renderContent() {
		if ( have_posts() ):
			while ( have_posts() ):
				the_post();

				View::partial( "main", "item_template", array(
					"component" => $this,
				) );

			endwhile;
		else:
			View::partial( 'main', '404', array(
				"component" => $this,
			) );
		endif;
	}
}
