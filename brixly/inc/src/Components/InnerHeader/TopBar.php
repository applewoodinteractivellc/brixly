<?php

namespace BrixlyWP\Theme\Components\InnerHeader;

use BrixlyWP\Theme\Components\Header\TopBar as HeaderTopBar;
use BrixlyWP\Theme\View;


class TopBar extends HeaderTopBar {
	protected static $settings_prefix = "header_post.navigation.";

	public function makeView() {
		View::partial( "front-header", "top-bar", array(
			"component" => $this,
		) );
	}
}
