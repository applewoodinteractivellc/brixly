<?php


namespace BrixlyWP\Theme\Components\Footer;


use BrixlyWP\Theme\AssetsManager;
use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\Translations;
use BrixlyWP\Theme\View;


class FrontFooter extends ComponentBase {

	protected static $settings_prefix = "footer_post.footer.";
	protected static $selector = ".page-footer";

	protected $background_component = null;

	public static function selectiveRefreshSelector() {
		return Defaults::get( static::$settings_prefix . 'selective_selector', false );
	}

	/**
	 * @return array();
	 */
	protected static function getOptions() {
		$prefix = static::$settings_prefix;

		return array(
			"sections" => array(
				"{$prefix}section" => array(
					'title'  => Translations::get( 'title' ),
					'panel'  => 'footer_panel',
					'type'   => 'brixly_section',
					'hidden' => true
				)
			),

			"settings" => array(

				"{$prefix}pen" => array(
					'control' => array(
						'type'    => 'pen',
						'section' => "footer",
					),

				),

				"{$prefix}props.useFooterParallax" => array(
					'default'   => Defaults::get( "{$prefix}props.useFooterParallax" ),
					'transport' => 'refresh',
					'control'   => array(
						'focus_alias' => 'footer',
						'label'       => Translations::get( 'footer_parallax' ),
						'type'        => 'switch',
						'show_toggle' => true,
						'section'     => "footer",
						'brixly_tab' => 'content',
					),
					'js_output' => array(
						array(
							'selector' => ".page-footer",
							'action'   => "brixly-component-toggle",
							'value'    => 'footerParallax'
						),
					),
				),
			),
		);
	}

	public function printParalaxJsToggle() {
		$prefix   = static::$settings_prefix;
		$parallax = $this->mod( "{$prefix}props.useFooterParallax", false );
		if ( $parallax === false || $parallax === "" ) {
			AssetsManager::addInlineScriptCallback( 'brixly-theme', function () {
				?>
                <script type="text/javascript">
                    jQuery(window).load(function () {
                        var el = jQuery(".page-footer");
                        var component = el.data()['fn.brixly.footerParallax'];
                        if (component) {
                            component.stop();
                        }
                    });
                </script>
				<?php
			} );
		}

	}

	public function renderContent() {
		View::partial( "front-footer", "footer", array(
			"component" => $this,
		) );
	}
}
