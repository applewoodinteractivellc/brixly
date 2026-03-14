<?php
/**
 * Created by PhpStorm.
 * User: yupal
 * Date: 2/11/2019
 * Time: 11:14 AM
 */

namespace BrixlyWP\Theme\Components;


use BrixlyWP\Theme\Core\ComponentBase;
use BrixlyWP\Theme\Defaults;
use BrixlyWP\Theme\Translations;

class FrontPageContent extends ComponentBase {

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
					'priority' => 2,
					'title'    => Translations::get( 'content_sections' ),
					'type'     => 'brixly_panel',
					'footer_buttons' => array(
						'change_header' => array(
							'label'         => Translations::get( 'add_section' ),
							'name'          => 'brixly_add_section',
							'classes'       => array( 'brixly-button-large', 'button-primary' ),
							'icon'          => 'dashicons-plus-alt',
						)
					)
				),
			),
		);
	}

	public function renderContent() {
		?>
        <div class="page-content">
            <div class="content">
				<?php
				while ( have_posts() ) : the_post();
					the_content();
				endwhile;
				?>
            </div>
        </div>
		<?php
	}


}
