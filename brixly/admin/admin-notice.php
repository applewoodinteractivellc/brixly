<div class="brixly-admin-big-notice--container">
    <div class="logo-holder">
        <h2><?php \BrixlyWP\Theme\Translations::escHtmlE( 'start_with_a_front_page' ); ?></h2>
    </div>
    <div class="content-holder">
        <ul class="predefined-front-pages">
			<?php foreach ( \BrixlyWP\Theme\Defaults::get( 'front_page_designs' ) as $brixly_design_index => $design ): ?>
				<?php $brixly_design_selected = $brixly_design_index === 0 ? 'selected' : ''; ?>
                <li data-index="<?php echo esc_attr( $design['index'] ); ?>"
                    class="<?php echo $brixly_design_selected; ?>">
                    <div class="predefined-front-page-card">
                        <div class="front-page-design-wrapper">
                            <div class="selected-badge"></div>
                            <div class="design-preview-image"
                                 style="background-image: url(<?php echo esc_attr( brixly_theme()->getAssetsManager()->getBaseURL() . "/images/front-page-{$design['index']}.png" ); ?>)"
                            ></div>
                        </div>
                        <div class="predefined-front-page-card-footer">
                            <h3 class="design-title">
								<?php echo esc_html( $design['name'] ); ?>
                            </h3>
                        </div>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
    <div class="content-footer ">
        <div class="action-buttons">
            <button class="button button-primary button-hero start-with-predefined-design-button">
				<?php \BrixlyWP\Theme\Translations::escHtmlE( 'start_with_selected_page' ); ?>
            </button>
            <span class="or-separator"><?php \BrixlyWP\Theme\Translations::escHtmlE( 'or' ); ?> </span>
            <button class="button button-hero view-all-demos">
				<?php \BrixlyWP\Theme\Translations::escHtmlE( 'check_all_demo_sites_page' ); ?>
            </button>
        </div>
        <div>
            <div class="plugin-notice">
                <span class="spinner"></span>
                <span class="message"></span>
            </div>
        </div>
        <div>
            <p class="description large-text"><?php \BrixlyWP\Theme\Translations::escHtmlE( 'start_with_a_front_page_plugin_info' ); ?></p>
        </div>
    </div>
    <script type="text/javascript">
		<?php $brixly_builder_status = array(
			"status"         => brixly_theme()->getPluginsManager()->getPluginState( 'brixly-page-builder' ),
			"install_url"    => brixly_theme()->getPluginsManager()->getInstallLink( 'brixly-page-builder' ),
			"activate_url"   => brixly_theme()->getPluginsManager()->getActivationLink( 'brixly-page-builder' ),
			"view_demos_url" => add_query_arg(
				array(
					'page'        => 'brixly-page-info',
					'current_tab' => 'demo-import'
				),
				admin_url( 'themes.php' )
			),
			"messages"       => array(
				"installing" => \BrixlyWP\Theme\Translations::get( 'installing',
					'Brixly Page Builder' ),
				"activating" => \BrixlyWP\Theme\Translations::get( 'activating',
					'Brixly Page Builder' )
			),
		); ?>
        var brixly_builder_status = <?php echo wp_json_encode( $brixly_builder_status ); ?>;
    </script>
</div>
