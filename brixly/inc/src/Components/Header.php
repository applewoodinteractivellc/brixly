<?php


namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Core\Hooks;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\Theme;
use BrixlyWP\Theme\Translations;
use BrixlyWP\Theme\View;

class Header extends ComponentBase {

	protected static function getOptions() {
		return array(
			"settings" => array(),

			"sections" => array(
				"top_bar" => array(
					'title'    => Translations::get( 'top_bar_settings' ),
					'priority' => 0,
					'panel'    => 'header_panel',
					'type'     => 'brixly_section',
				),

				"nav_bar" => array(
					'title'    => Translations::get( 'nav_settings' ),
					'priority' => 0,
					'panel'    => 'header_panel',
					'type'     => 'brixly_section',
				),

				"hero" => array(
					'title'    => Translations::get( 'hero_settings' ),
					'priority' => 0,
					'panel'    => 'header_panel',
					'type'     => 'brixly_section',
				),
			),

			"panels" => array(
				"header_panel" => array(
					'priority'       => 1,
					'title'          => Translations::get( 'header_sections' ),
					'type'           => 'brixly_panel',
					'footer_buttons' => array(
						'change_header' => array(
							'label'         => Translations::get('change_header_design'),
							'name'          => 'brixly_headers_panel',
							'classes'       => array( 'brixly-button-large', 'brixly-button-orange' ),
							'icon'          => 'dashicons-admin-customizer',
							'activate_when' => array(
								'selector' => Defaults::get( 'header_front_page.hero.selective_selector', false )
							)
						)
					)
				),
			),
		);
	}

	/**
	 * @throws \Exception
	 */
	public function renderContent() {

		Hooks::brixly_do_action( 'before_header' );
		$header_class = View::isFrontPage() ? "header-front-page" : "header-inner-page";
		$this->printSkipToContent();
		?>
        <div class="header <?php echo $header_class; ?>">
			<?php View::isFrontPage() ? $this->renderFrontPageFragment() : $this->renderInnerPageFragment(); ?>
        </div>
        <script type='text/javascript'>
            (function () {
                // forEach polyfill
                if (!NodeList.prototype.forEach) {
                    NodeList.prototype.forEach = function (callback) {
                        for (var i = 0; i < this.length; i++) {
                            callback.call(this, this.item(i));
                        }
                    }
                }

                var navigation = document.querySelector('[data-brixly-navigation-overlap="true"], [data-brixly-component="navigation"][data-overlap="true"]')
                if (navigation) {
                    var els = document
                        .querySelectorAll('.h-navigation-padding');
                    if (els.length) {
                        els.forEach(function (item) {
                            item.style.paddingTop = navigation.offsetHeight + "px";
                        });
                    }
                }
            })();
        </script>
		<?php
	}

	private function printSkipToContent() {
		?>
        <script>
            /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function () {
                var t, e = location.hash.substring(1);
                /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
            }, !1);
        </script>
        <a class="skip-link screen-reader-text" href="#content">
			<?php Translations::escHtmlE( 'skip_to_content' ) ?>
        </a>
		<?php
	}

	/**
	 * @throws \Exception
	 */
	private function renderFrontPageFragment() {

		//Theme::getInstance()->get( 'top-bar' )->render();
		Theme::getInstance()->get( 'front-nav-bar' )->render();
		Theme::getInstance()->get( 'front-hero' )->render();
	}

	private function renderInnerPageFragment() {
		//Theme::getInstance()->get( 'top-bar' )->render();
		Theme::getInstance()->get( 'inner-nav-bar' )->render();
		Theme::getInstance()->get( 'inner-hero' )->render();
	}

	public function getRenderData() {
		return array(
			'mods' => $this->mods(),
		);
	}
}
