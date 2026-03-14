<?php


namespace BrixlyWP\Theme;


use BrixlyWP\Theme\Core\Hooks;
use BrixlyWP\Theme\Core\Utils;

class Defaults {
	private static $defaults = array();

	private static $loaded = false;

	public static function getDefaults() {
		return static::$defaults;
	}

	public static function get( $key, $fallback = null ) {
		static::load();

		return Utils::pathGet( static::$defaults, $key, $fallback );
	}

	public static function load() {

		if ( static::$loaded ) {
			return;
		}

		static::$defaults = require_once get_template_directory() . "/inc/defaults.php";

		if ( file_exists( get_template_directory() . "/inc/template-defaults.php" ) ) {
			$template_defaults = require_once get_template_directory() . "/inc/template-defaults.php";
			static::$defaults  = array_replace_recursive( $template_defaults, static::$defaults );
		}

		static::$defaults = Hooks::brixly_apply_filters( 'defaults', static::$defaults );
		static::$loaded   = true;
	}

}
