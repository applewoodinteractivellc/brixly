<?php


namespace BrixlyWP\Theme;


use BrixlyWP\Theme\Core\ConfigurableInterface;
use BrixlyWP\Theme\Core\Hooks;
use BrixlyWP\Theme\Core\Tree;
use BrixlyWP\Theme\Core\Utils;
use BrixlyWP\Theme\Customizer\ControlFactory;
use BrixlyWP\Theme\Customizer\Controls\BrixlyControl;
use BrixlyWP\Theme\Customizer\CustomizerApi;
use BrixlyWP\Theme\Customizer\PanelFactory;
use BrixlyWP\Theme\Customizer\SectionFactory;

class Customizer {

	const TYPE_CONTROL = "control";
	const TYPE_SECTION = "section";
	const TYPE_PANEL = "panel";

	private $theme = null;
	private $options;
	private $sections = array();
	private $panels = array();
	private $settings = array();


	public function __construct( Theme $theme ) {

		new CustomizerApi();
		$this->theme   = $theme;
		$this->options = new Tree();

	}

	public static function sanitize( $value ) {

		if ( is_bool( $value ) ) {
			return $value;
		}

		return (string) $value;
	}

	public function boot() {

		if ( Hooks::brixly_apply_filters( 'customizer_skip_boot', false ) ) {
			return;
		}

		add_action( 'customize_register', array( $this, 'prepareOptions' ), 0, 0 );
		add_action( 'customize_register', array( $this, 'prepareTypes' ), 0, 1 );

		// register customizer structure
		add_action( 'customize_register', array( $this, 'registerPanels' ), 1, 1 );
		add_action( 'customize_register', array( $this, 'registerSections' ), 2, 1 );

		// register customizer components
		add_action( 'customize_register', array( $this, 'registerSettings' ), 3, 1 );
		add_action( 'customize_register', array( $this, 'registerControls' ), 4, 1 );

		// additional elements
		add_action( 'customize_register', array( $this, 'registerPartialRefresh' ), 5, 1 );
		$this->inPreview( function () {
			add_action( 'wp_print_footer_scripts', function () {

				?>
                <script data-name="brixly-preview-options">
                    var brixly_CSS_OUTPUT_CONTROLS = <?php echo wp_json_encode( ControlFactory::getCssOutputControls() ); ?>;
                    var brixly_JS_OUTPUT_CONTROLS = <?php echo wp_json_encode( ControlFactory::getJsOutputControls() ); ?>;
                    var brixly_CONTROLS_ACTIVE_RULES = <?php echo wp_json_encode( ControlFactory::getActiveRules() ); ?>;
                    var brixly_ADDITIONAL_JS_DATA = <?php echo wp_json_encode( (object) Hooks::brixly_apply_filters( 'customizer_additional_js_data',
						array() ) ); ?>;
                </script>
				<?php
			}, PHP_INT_MAX );
		} );

		// rearrange customizer components
		add_action( 'customize_register', array( $this, 'rearrangeComponents' ), PHP_INT_MAX, 1 );

		// add customizer js / css
		add_action( 'customize_controls_print_scripts', array( $this, 'registerAssets' ), PHP_INT_MAX, 1 );

		//
		$this->onPreviewInit( array( $this, 'previewInit' ) );


	}

	public function inPreview( $callback ) {
		if ( is_customize_preview() && is_callable( $callback ) ) {
			call_user_func( $callback );
		}
	}

	public function onPreviewInit( $callback, $priorty = 10 ) {

		add_action( 'customize_preview_init', $callback, $priorty );
	}

	public function getSettingQuickLink( $value ) {
		return add_query_arg( 'brixly_autofocus', $value, admin_url( "/customize.php" ) );
	}

	public function prepareOptions() {

		new HeaderPresets();

		$components = $this->theme->getRepository()->getAllDefinitions();
		$options    = array(
			"settings" => array(),
			"sections" => array(),
			"panels"   => array(),
		);

		foreach ( $components as $key => $component ) {
			$interfaces = class_implements( $component );

			if ( array_key_exists( ConfigurableInterface::class, $interfaces ) ) {

				/** @var ConfigurableInterface $component */
				$opts = (array) $component::options();

				foreach ( $options as $opt_key => $value ) {

					if ( array_key_exists( $opt_key, $opts ) && is_array( $opts[ $opt_key ] ) ) {

						$options[ $opt_key ] = array_merge( $options[ $opt_key ], $opts[ $opt_key ] );

					}

				}
			}

		}

		$options = Hooks::brixly_apply_filters( 'customizer_options', $options );

		//set initial section > tabs to empty = true
		$tabs     = array( 'content' => true, 'style' => true, 'layout' => true );
		$sections = array_flip( array_keys( $options['sections'] ) );
		array_walk( $sections, function ( &$value, $key ) use ( $tabs ) {
			$value = array( 'tabs' => $tabs );
		} );

		//set section > tabs that have controls empty = false
		foreach ( $options['settings'] as $setting => $value ) {
			$section                              = $value['control']['section'];
			$tab                                  = Utils::pathGet( $value, 'control.brixly_tab', 'content' );
			$sections[ $section ]['tabs'][ $tab ] = false;
		}

		foreach ( $sections as $section => $values ) {
			foreach ( $values['tabs'] as $tab => $tab_empty ) {
				if ( $tab_empty ) {
					//var_dump($section);
					$key                         = "{$section}-{$tab}-plugin-message";
					$options['settings'][ $key ] = array(
						'control' => array(
							'type'        => 'plugin-message',
							'section'     => $section,
							'brixly_tab' => $tab,
						)
					);
				}
			}
		}

		if ( isset( $_REQUEST['brixly_export_default_options'] ) && is_admin() ) {
			$defaults = array();

			foreach ( $options['settings'] as $key => $value ) {
				$defaults[ $key ] = str_replace(
					site_url(),
					'%s',
					Utils::pathGet( $value, 'default', '' )
				);
			}

			wp_send_json_success( $defaults );
		}

		$this->options->setData( $options );
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function prepareTypes( $wp_customize ) {
		$types = Hooks::brixly_apply_filters( 'customizer_types', array() );
		foreach ( $types as $class => $type ) {
			switch ( $type ) {
				case Customizer::TYPE_CONTROL:
					$wp_customize->register_control_type( $class );
					break;

				case Customizer::TYPE_SECTION:
					$wp_customize->register_section_type( $class );
					break;

				case Customizer::TYPE_PANEL:
					$wp_customize->register_panel_type( $class );
					break;
			}

		}

	}

	public function registerPanels() {
		$this->panels = new Tree( $this->options->findAt( "panels" ) );

		$this->panels->walkFirstLevel( function ( $id, $data ) {
			PanelFactory::make( $id, $data );
		} );
	}

	public function registerSections() {
		$this->sections = new Tree( $this->options->findAt( "sections" ) );

		$this->sections->walkFirstLevel( function ( $id, $data ) {
			SectionFactory::make( $id, $data );
		} );
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function registerSettings( $wp_customize ) {
		$this->settings = new Tree( $this->options->findAt( "settings" ) );

		$this->settings->walkFirstLevel( function ( $id, $data ) use ( $wp_customize ) {

			$data = array_merge( array(
				'transport' => 'brixly_selective_refresh',
				'default'   => '',
			), $data );

			if ( isset( $data['setting'] ) ) {
				$id = $data['setting'];
			}

			if ( ! ( isset( $data['settingless'] ) && $data['settingless'] ) ) {
				if ( ! $wp_customize->get_setting( $id ) ) {
					$wp_customize->add_setting( $id, array(
						'transport'         => $data['transport'],
						'default'           => $data['default'],
						'sanitize_callback' => array( __CLASS__, "sanitize" ),
					) );
				}
			}

			if ( isset( $data['control'] ) ) {

				$control = array_merge( array(
					'default'   => $data['default'],
					'transport' => $data['transport'],

				), $data['control'] );

				if ( array_key_exists( 'css_output', $data ) ) {
					$control['transport']  = 'css_output';
					$control['css_output'] = $data['css_output'];
				}
				if ( array_key_exists( 'js_output', $data ) ) {
					$control['transport'] = 'js_output';
					$control['js_output'] = $data['js_output'];
				}
				if ( array_key_exists( 'active_rules', $data ) ) {
					$control['active_rules'] = $data['active_rules'];
				}

				$control['settingless'] = ( isset( $data['settingless'] ) && $data['settingless'] );

				ControlFactory::make( $id, $control );
			}

		} );


	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function registerControls( $wp_customize ) {

	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function registerPartialRefresh( $wp_customize ) {
		$partials = ControlFactory::getPartialRefreshes();

		Hooks::brixly_add_filter( 'customizer_additional_js_data', function ( $value ) use ( $partials ) {
			$value['selective_refresh_settings'] = array();

			foreach ( $partials as $partial ) {
				$value['selective_refresh_settings'] = array_merge( $value['selective_refresh_settings'],
					$partial['settings'] );
			}

			return $value;
		} );

		foreach ( $partials as $key => $args ) {
			$wp_customize->selective_refresh->add_partial( $key, $args );
		}
	}

	/**
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public function rearrangeComponents( $wp_customize ) {

		Hooks::brixly_do_action( 'rearrange_customizer_components', $wp_customize );
	}

	public function registerAssets() {


		$base_url = $this->theme->getAssetsManager()->getBaseURL();

		wp_register_script( Hooks::HOOK_PREFIX . "customizer",
			$base_url . "/customizer/customizer.js", array( 'jquery' ),
			$this->theme->getVersion(), true );

		wp_localize_script( Hooks::HOOK_PREFIX . "customizer", 'brixly_Customizer_Data',
			Hooks::brixly_apply_filters( 'customizer_js_data', array(
				'translations'              => Translations::all(),
				'section_default_tab'       => BrixlyControl::DEFAULT_BRIXLY_TAB,
				'style_tab'                 => BrixlyControl::STYLE_BRIXLY_TAB,
				'brixly_autofocus'         => Utils::pathGet( $_REQUEST, 'brixly_autofocus' ),
				'brixly_autofocus_aliases' => (object) Hooks::brixly_apply_filters( 'customizer_autofocus_aliases',
					array() )
			) ) );

		wp_register_style( Hooks::HOOK_PREFIX . "customizer",
			$base_url . "/customizer/customizer.css", array( 'customize-controls' ),
			$this->theme->getVersion() );

		wp_enqueue_style( Hooks::HOOK_PREFIX . "customizer" );
		wp_enqueue_script( Hooks::HOOK_PREFIX . "customizer" );
	}

	public function isInPreview() {
		return \is_customize_preview();
	}

	public function isCustomizer( $callback ) {
		if ( is_customize_preview() && is_callable( $callback ) ) {
			call_user_func( $callback );
		}
	}

	public function previewInit() {

		$base_url = $this->theme->getAssetsManager()->getBaseURL();

		wp_enqueue_style( Hooks::HOOK_PREFIX . "customizer_preview",
			$base_url . "/customizer/preview.css", Theme::getInstance()->getVersion() );


		wp_enqueue_script( Hooks::HOOK_PREFIX . "customizer_preview",
			$base_url . "/customizer/preview.js", array(
				'customize-preview',
				'customize-selective-refresh'
			),
			Theme::getInstance()->getVersion(), true );


		AssetsManager::addInlineScriptCallback(
			Hooks::HOOK_PREFIX . "customizer_preview",
			function () {
				?>
                <script type="text/javascript">
                    (function () {
                        function ready(callback) {
                            if (document.readyState !== 'loading') {
                                callback();
                            } else {
                                if (document.addEventListener) {
                                    document.addEventListener('DOMContentLoaded', callback);

                                } else {
                                    document.attachEvent('onreadystatechange', function () {
                                        if (document.readyState === 'complete') callback();
                                    });
                                }
                            }
                        }

                        ready(function () {
                            setTimeout(function () {
                                parent.wp.customize.trigger('brixly_preview_ready');
                            }, 500);
                        })
                    })();
                </script>
				<?php
			}
		);
	}

	/**
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}
}
