<?php
/**
 * Created by PhpStorm.
 * User: yupal
 * Date: 2/14/2019
 * Time: 6:28 PM
 */

namespace BrixlyWP\Theme\Components\FrontHeader;


use BrixlyWP\Theme\AssetsManager;
use BrixlyWP\Theme\Components\Header\NavBarStyle;
use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\View;

class NavBar extends ComponentBase {

	protected static $settings_prefix = "header_front_page.navigation.";

	/**
	 * @return array();
	 */
	protected static function getOptions() {
		$style = static::style()->getOptions();

		return $style;
	}

	/**
	 * @return NavBarStyle
	 */
	public static function style() {
		return NavBarStyle::getInstance( static::getPrefix(), static::selectiveRefreshSelector() );
	}

	protected static function getPrefix() {
		return static::$settings_prefix;
	}

	public static function selectiveRefreshSelector() {
		return Defaults::get( static::getPrefix() . 'selective_selector', false );
	}


	public function renderContent() {
		static::style()->renderContent();

		$template = static::style()->mod( 'bar_type' );
		View::partial( "front-header", "navigation", array(
			"component" => $this,
		) );
	}

	public function printHeaderMenu() {
		View::printMenu( array(
			'id'      => 'header-menu',
			'classes' => 'none',
		) );
	}

	public function printSticky() {
		$sticky = static::style()->mod( "props.sticky" );
		if ( $sticky === false || $sticky === "" ) {

			AssetsManager::addInlineScriptCallback(
				'brixly-theme',
				function () {
					?>
                    <script type="text/javascript">
                        jQuery(window).load(function () {
                            var el = jQuery("#navigation");
                            var component = el.data()['fn.brixly.navigation'];
                            if (component) {
                                window.brixlyNavStickyOpts = component.opts.data.sticky;
                                component.opts.data.sticky = false;
                                if (component.hasOwnProperty('restart')) {
                                    component.restart();
                                } else {
                                    component.stop();
                                    component.start();
                                }
                            }
                        });
                    </script>
					<?php
				}
			);

		}

	}

	public function printWrapperClasses() {
		$classes = array( 'navigation-wrapper' );
		$prefix  = static::getPrefix();

		if ( $this->mod( "{$prefix}boxed_navigation", false ) ) {
			$classes[] = "gridContainer";
		}

		echo esc_attr( implode( " ", $classes ) );
	}

	public function printNavigationClasses() {
		$classes = array();
		$prefix  = static::getPrefix();

		if ( $this->mod( "{$prefix}props.overlap", Defaults::get( "{$prefix}props.overlap", true ) ) ) {
			$classes[] = "h-navigation_overlap";
		}
		if ( $width = $this->mod( "{$prefix}props.width", 'boxed' ) ) {
			$classes[] = "brixly-theme-nav-{$width}";
		}

		echo esc_attr( implode( " ", $classes ) );
	}

	public function printContainerClasses() {
		$classes = array();
		$prefix  = static::getPrefix();

		$width_options = array(
			'boxed'      => 'h-section-boxed-container',
			'full-width' => 'h-section-fluid-container'
		);

		if ( $width = $this->mod( "{$prefix}props.width", 'boxed' ) ) {
			$classes[] = $width_options[ $width ];
		}

		echo esc_attr( implode( " ", $classes ) );
	}
}
