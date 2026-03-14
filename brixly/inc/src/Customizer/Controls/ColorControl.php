<?php


namespace BrixlyWP\Theme\Customizer\Controls;


class ColorControl extends VueControl {
	public    $type                    = 'brixly-color';
	protected $inline_content_template = true;


	protected function printVueContent() {
		?>
        <el-color-picker
                v-model="value"
                :size="size"
                :show-alpha="alpha"
                @change="setValue"
                @active-change="activeChange"
                <# (data.alpha == 'false') ? '': print('show-alpha') #>
        >
        </el-color-picker>
		<?php
	}
}
