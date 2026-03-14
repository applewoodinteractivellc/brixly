<?php
use BrixlyWP\Theme\Translations;

$is_builder_installed = apply_filters( 'brixly_page_builder/installed', false );
$get_setting_link = function($setting) {
    return esc_attr(brixly_theme()->getCustomizer()->getSettingQuickLink($setting));
}
?>

<div class="brixly-get-started__container brixly-admin-panel">
    <div class="brixly-get-started__section">
        <h2 class="col-title brixly-get-started__section-title">
            <span class="brixly-get-started__section-title__icon dashicons dashicons-admin-plugins"></span>
			<?php Translations::escHtmlE( 'get_started_section_1_title' ); ?>
        </h2>
        <div class="brixly-get-started__content">


			<?php foreach ( brixly_theme()->getPluginsManager()->getPluginData() as $slug => $plugin_data ): ?>
				<?php
				$brixly_plugin_state = brixly_theme()->getPluginsManager()->getPluginState( $slug );
				$brixly_notice_type  = $brixly_plugin_state === \BrixlyWP\Theme\PluginsManager::ACTIVE_PLUGIN ? 'blue' : '';
				?>
                <div class="brixly-notice <?php echo esc_attr( $brixly_notice_type ); ?>">
                    <div class="brixly-notice__header">
                        <h3 class="brixly-notice__title"><?php echo esc_html( brixly_theme()->getPluginsManager()->getPluginData( "{$slug}.name" ) ); ?></h3>
                        <div class="brixly-notice__action">
							<?php if ( $brixly_plugin_state === \BrixlyWP\Theme\PluginsManager::ACTIVE_PLUGIN ): ?>
                                <p class="brixly-notice__action__active"><?php \BrixlyWP\Theme\Translations::escHtmlE( 'plugin_installed_and_active' ); ?> </p>
							<?php else: ?>
								<?php if ( $brixly_plugin_state === \BrixlyWP\Theme\PluginsManager::INSTALLED_PLUGIN ): ?>
                                    <a class="button button-large"
                                       href="<?php echo esc_attr( brixly_theme()->getPluginsManager()->getActivationLink( $slug ) ); ?>">
										<?php \BrixlyWP\Theme\Translations::escHtmlE( 'activate' ); ?>
                                    </a>
								<?php else: ?>
                                    <a class="button button-large"
                                       href="<?php echo esc_attr( brixly_theme()->getPluginsManager()->getInstallLink( $slug ) ); ?>">
										<?php \BrixlyWP\Theme\Translations::escHtmlE( 'install' ); ?>
                                    </a>
								<?php endif; ?>
							<?php endif; ?>
                        </div>
                    </div>
                    <p class="brixly-notice__description"><?php echo esc_html( brixly_theme()->getPluginsManager()->getPluginData( "{$slug}.description" ) ); ?></p>


                </div>
			<?php endforeach; ?>
        </div>
    </div>
    <div class="brixly-get-started__section">
        <h2 class="brixly-get-started__section-title">
            <span class="brixly-get-started__section-title__icon dashicons dashicons-admin-appearance"></span>
			<?php Translations::escHtmlE( 'get_started_section_2_title' ); ?>
        </h2>
        <div class="brixly-get-started__content">
            <div class="brixly-customizer-option__container">
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-format-image"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('logo');?>" >
                        <?php Translations::escHtmlE( 'get_started_set_logo' ); ?>
                    </a>
                </div>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-format-image"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('hero_background'); ?>" >
	                    <?php Translations::escHtmlE( 'get_started_change_hero_image' ); ?>
                    </a>
                </div>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-menu-alt3"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('navigation'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_change_customize_navigation' ); ?>
                    </a>
                </div>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-layout"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('hero_layout'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_change_customize_hero' ); ?>
                    </a>
                </div>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-admin-appearance"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('footer'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_customize_footer' ); ?>
                    </a>
                </div>
                <?php if($is_builder_installed): ?>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-art"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('color_scheme'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_change_color_settings' ); ?>
                    </a>
                </div>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-editor-textcolor"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('general_typography'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_customize_fonts' ); ?>
                    </a>
                </div>

                <?php endif; ?>
                <div class="brixly-customizer-option">
                    <span class="brixly-customizer-option__icon dashicons dashicons-menu-alt3"></span>
                    <a class="brixly-customizer-option__label"
                       target="_blank"
                       href="<?php echo $get_setting_link('menu'); ?>" >
		                <?php Translations::escHtmlE( 'get_started_set_menu_links' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
