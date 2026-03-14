<?php

use BrixlyWP\Theme\Translations;

$brixly_info_page_support_link = \BrixlyWP\Theme\Core\Hooks::brixly_apply_filters( 'info_page_support_link',
	'https://brixly.com/#support' );

$brixly_info_page_review_link  = \BrixlyWP\Theme\Core\Hooks::brixly_apply_filters( 'info_page_review_link',
	'https://wordpress.org/support/theme/' . get_template() . '/reviews/' );

$brixly_info_page_docs_link  = \BrixlyWP\Theme\Core\Hooks::brixly_apply_filters( 'info_page_docs_link',
	'https://docs.brixly.com/' );

?>

<div class="brixly-admin-sidebar brixly-admin-panel">
    <div class="brixly-admin-sidebar__section">
        <div class="brixly-admin-sidebar__section__title">
            <span class="brixly-admin-sidebar__section__icon dashicons dashicons-media-text"></span>
            <h2><?php Translations::escHtmlE( 'admin_sidebar_documentation_title' ); ?></h2>
        </div>

        <p class="brixly-admin-sidebar__section__description">
			<?php Translations::escHtmlE( 'admin_sidebar_documentation_description' ); ?>
        </p>
        <a href="<?php echo esc_attr($brixly_info_page_docs_link); ?>" target="_blank" class="button button-primary">
			<?php Translations::escHtmlE( 'admin_sidebar_documentation_action' ); ?>
        </a>
    </div>
    <div class="brixly-admin-sidebar__section">
        <div class="brixly-admin-sidebar__section__title">
            <span class="brixly-admin-sidebar__section__icon dashicons dashicons-sos"></span>
            <h2><?php Translations::escHtmlE( 'admin_sidebar_support_title' ); ?></h2>
        </div>
        <p class="brixly-admin-sidebar__section__description">
			<?php Translations::escHtmlE( 'admin_sidebar_support_description' ); ?>
        </p>
        <a href="<?php echo esc_attr($brixly_info_page_support_link); ?>" target="_blank" class="button button-primary">
			<?php Translations::escHtmlE( 'admin_sidebar_support_action' ); ?>
        </a>
    </div>
    <div class="brixly-admin-sidebar__section">
        <div class="brixly-admin-sidebar__section__title">
            <span class="brixly-admin-sidebar__section__icon dashicons dashicons-star-filled"></span>
            <h2><?php Translations::escHtmlE( 'admin_sidebar_review_title' ); ?></h2>
        </div>
        <p class="brixly-admin-sidebar__section__description">
			<?php Translations::escHtmlE( 'admin_sidebar_review_description' ); ?>
        </p>
        <a href="<?php echo esc_attr($brixly_info_page_review_link); ?>" target="_blank" class="button button-primary">
			<?php Translations::escHtmlE( 'admin_sidebar_review_action' ); ?>
        </a>
    </div>
</div>
