<?php
/**
 * Created by PhpStorm.
 * User: yupal
 * Date: 2/11/2019
 * Time: 7:02 PM
 */

namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Theme;
use BrixlyWP\Theme\View;

class SingleContent extends MainContent {

	public static function selectiveRefreshSelector() {
		return "#content";
	}

	public function renderContent() {

		View::printIn( View::CONTENT_ELEMENT, function () {
			View::printIn( View::SECTION_ELEMENT, function () {
				View::printIn( View::ROW_ELEMENT, function () {
					View::printIn( View::COLUMN_ELEMENT, function () {

						Theme::getInstance()->get( 'single-template' )->render();

					} );
					Theme::getInstance()->get( 'sidebar' )->render();
				} );
			} );
		}, array( array( 'post-single', 'brixly-main-content-area-single' ) ) );
	}
}
