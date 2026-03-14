<?php


namespace BrixlyWP\Theme\Customizer\Controls;


use BrixlyWP\Theme\Translations;

class RepeaterControl extends VueControl {

	public $type = 'brixly-repeater';
	private $fields = array();


	protected function printVueContent() {
		?>

        <div class="brixly-fullwidth">
            <div class="brixly-fullwidth">
                <el-collapse v-sortable-el-accordion="onSortEnd">

                    <el-collapse-item v-for="(item,index) in items" :name="index" :key="item.index">

                        <template slot="title">
							<?php $this->vueEcho( "itemsLabels[index]" ); ?>
                        </template>

                        <ul class="field-data">
                            <li v-for="(field,name) in fields" :key="name">
                                <label class="field-label"><?php $this->vueEcho( "field.label" ); ?></label>
                                <div class="component-holder"
                                     :is="getComponentType(field.type)"
                                     :value="item[name]"
                                     v-bind="field.props"
                                     @change="propChanged($event,item,name)"></div>
                            </li>
                        </ul>

                        <el-button class="el-button--danger" type="text" v-show="canRemoveItem"
                                   @click="removeItem(index)"><?php Translations::escHtmlE( 'remove' ); ?></el-button>

                    </el-collapse-item>

                </el-collapse>
            </div>

            <div class="brixly-fullwidth">
                <el-button size="medium" v-show="canAdd"
                           @click="addItem()"><?php $this->vueEcho( 'item_add_label' ); ?></el-button>
            </div>
        </div>
		<?php
	}

}
