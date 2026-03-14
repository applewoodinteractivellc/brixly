<?php

namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Translations;
use BrixlyWP\Theme\View;

class PageContent extends ComponentBase {

	public static function selectiveRefreshSelector() {
		return '.brixly-page-content';
	}

	/**
	 * @return array();
	 */
	protected static function getOptions() {
		$prefix = 'page_content_';

		return array(
			"sections" => array(
				"{$prefix}section" => array(
					'title' => Translations::get( 'content_settings' ),
					'panel' => 'content_panel',
					'type'  => 'brixly_section',
				)
			),

			"settings" => array(
				"{$prefix}pen" => array(
					'control' => array(
						'type'        => 'pen',
						'section'     => "{$prefix}section",
						'brixly_tab' => 'content',
					),

				),

				"{$prefix}plugin-content" => array(
					'control' => array(
						'type'        => 'plugin-message',
						'section'     => "{$prefix}section",
						'brixly_tab' => 'content',
					)
				),

			),

			"panels" => array(
				"content_panel" => array(
					'priority'       => 2,
					'title'          => Translations::get( 'content_sections' ),
					'type'           => 'brixly_panel',
					'footer_buttons' => array(
						'change_header' => array(
							'label'   => Translations::get( 'add_section' ),
							'name'    => 'brixly_add_section',
							'classes' => array( 'brixly-button-large', 'button-primary' ),
							'icon'    => 'dashicons-plus-alt',
						)
					)
				),
			),
		);
	}

	public function renderContent() {

		View::printIn( View::CONTENT_ELEMENT, function () {
			View::printIn( View::SECTION_ELEMENT, function () {
				View::printIn( View::ROW_ELEMENT, function () {
					View::printIn( View::COLUMN_ELEMENT, function () {
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content/content', 'page' );
						endwhile;
					} );
				} );
			} );
		}, array( array( 'page-content', 'brixly-page-content' ) ) );
	}
}
