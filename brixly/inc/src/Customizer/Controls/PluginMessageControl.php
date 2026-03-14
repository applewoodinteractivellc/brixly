<?php


namespace BrixlyWP\Theme\Customizer\Controls;


use BrixlyWP\Theme\Core\Hooks;
use BrixlyWP\Theme\PluginsManager;
use BrixlyWP\Theme\Translations;

class PluginMessageControl extends VueControl {

	public $type = "brixly-plugin-message";

	protected function printVueContent() {

		$this->addData();

		?>
        <div class="plugin-message card">
            <p>
				<?php echo Translations::get( 'plugin_message', 'Brixly Page Builder' ); ?>
            </p>
			<?php if ( brixly_theme()->getPluginsManager()->getPluginState( 'brixly-page-builder' ) === PluginsManager::NOT_INSTALLED_PLUGIN ): ?>
                <button data-brixly-plugin-action="install"
                        class="el-button el-link h-col el-button--primary el-button--small"
                        style="text-decoration: none">
					<?php echo Translations::get( 'install_with_placeholder', 'Brixly Page Builder' ); ?>
                </button>
			<?php endif; ?>

			<?php if ( brixly_theme()->getPluginsManager()->getPluginState( 'brixly-page-builder' ) === PluginsManager::INSTALLED_PLUGIN ): ?>
                <button data-brixly-plugin-action="activate"
                        class="el-button el-link h-col el-button--primary el-button--small"
                        style="text-decoration: none">
					<?php echo Translations::get( 'activate_with_placeholder', 'Brixly Page Builder' ); ?>
                </button>
			<?php endif; ?>

            <p class="notice notice-large" data-brixly-plugin-action-message="1" style="display: none"></p>
        </div>
		<?php
	}

	public function addData() {

		if ( Hooks::brixly_apply_filters( 'plugin-customizer-controller-data-added', false ) ) {
			return;
		}

		Hooks::brixly_add_filter( 'plugin-customizer-controller-data-added', '__return_true' );

		add_action( 'customize_controls_print_footer_scripts', function () {

			$data = array(
				"status"       => brixly_theme()->getPluginsManager()->getPluginState( 'brixly-page-builder' ),
				"install_url"  => brixly_theme()->getPluginsManager()->getInstallLink( 'brixly-page-builder' ),
				"activate_url" => brixly_theme()->getPluginsManager()->getActivationLink( 'brixly-page-builder' ),
				"messages"     => array(
					"installing" => \BrixlyWP\Theme\Translations::get( 'installing',
						'Brixly Page Builder' ),
					"activating" => \BrixlyWP\Theme\Translations::get( 'activating',
						'Brixly Page Builder' )
				),
				"admin_url"    => add_query_arg( 'brixly_create_pages', '1', admin_url() ),
			);
			?>
            <script>
                window.brixly_plugin_status = <?php echo json_encode( $data ); ?>
            </script>
			<?php
		}, PHP_INT_MAX );

	}
}
