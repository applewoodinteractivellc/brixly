<?php


namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Core\Hooks;
use BrixlyWP\Theme\Theme;
use BrixlyWP\Theme\Translations;
use BrixlyWP\Theme\View;

class Footer extends ComponentBase {

	public static function selectiveRefreshSelector() {
		$footer_class = View::isFrontPage() ? "footer-front-page" : "footer-inner-page";

		return ".footer.{$footer_class}";
	}

	protected static function getOptions() {

		return array(
			"settings" => array(),
			"sections" => array(
				"footer" => array(
					'title'    => Translations::get( 'footer_settings' ),
					'priority' => 0,
					'panel'    => 'footer_panel',
					'type'     => 'brixly_section',

				),
			),

			"panels" => array(
				"footer_panel" => array(
					'priority'       => 3,
					'title'          => Translations::get( 'footer_sections' ),
					'type'           => 'brixly_panel',
					'footer_buttons' => array(
						'change_header' => array(
							'label'   => Translations::get( 'change_footer_design' ),
							'name'    => 'brixly_footers_panel',
							'classes' => array( 'brixly-button-large', 'button-primary' ),
							'icon'    => 'dashicons-admin-customizer',
						)
					)
				),
			),
		);

	}

	public function printCopyright() {
		$colibr_theme_url = sprintf(
			'<a target="_blank" href="%s" class="mesmerize-theme-link">%s</a>',
			"https://brixly.com",
			__( 'Brixly Theme', 'brixly' )
		);

		$copyrightText = sprintf(
			__( 'Built using WordPress and the %s', 'brixly' ),
			$colibr_theme_url
		);

		$copyright = sprintf(
			'<p class="copyright">&copy;&nbsp;&nbsp;%s&nbsp;%s.&nbsp;%s</p>',
			date_i18n( __( 'Y', 'brixly' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			$copyrightText
		);

		echo $copyright;
	}

	public function renderContent() {

		Hooks::brixly_do_action( 'before_footer' );
		$footer_class = View::isFrontPage() ? "footer-front-page" : "footer-inner-page";

		?>
        <div class="footer <?php echo $footer_class; ?>">
			<?php Theme::getInstance()->get( 'front-footer' )->render(); ?>
        </div>
		<?php
	}
}
