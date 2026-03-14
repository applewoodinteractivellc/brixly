<?php


namespace BrixlyWP\Theme\Customizer\Controls;


trait BrixlyWPControlsAdapter {

	protected $brixly_tab  = BrixlyControl::DEFAULT_BRIXLY_TAB;
	protected $default      = '';
	protected $active_rules = array();

	public function json() {
		$json                 = parent::json();
		$json['brixly_tab']  = $this->brixly_tab;
		$json['active_rules'] = $this->active_rules;

		return $json;
	}
}
