<?php


$brixly_tabs            = \BrixlyWP\Theme\View::getData( 'tabs', array() );
$brixly_current_tab     = \BrixlyWP\Theme\View::getData( 'current_tab', null );
$brixly_url             = \BrixlyWP\Theme\View::getData( 'page_url', null );
$brixly_welcome_message = \BrixlyWP\Theme\View::getData( 'welcome_message', null );
$brixly_tab_partial     = \BrixlyWP\Theme\View::getData( "tabs.{$brixly_current_tab}.tab_partial", null );
\BrixlyWP\Theme\Core\Hooks::brixly_do_action("before_info_page_tab_{$brixly_current_tab}");

?>
<div class="brixly-admin-page wrap about-wrap full-width-layout mesmerize-page">

    <div class="brixly-admin-page--hero">
        <div class="brixly-admin-page--hero-intro brixly-admin-page-spacing ">
            <div class="brixly-admin-page--hero-logo">
                <img src="<?php echo esc_attr( brixly_theme()->getAssetsManager()->getBaseURL() . "/images/brixly-logo.png" ) ?>"
                     alt="logo"/>
            </div>
            <div class="brixly-admin-page--hero-text ">
				<?php if ( $brixly_welcome_message ): ?>
                    <h1><?php echo esc_html( $brixly_welcome_message ); ?></h1>
				<?php endif; ?>
            </div>
        </div>
	<?php if ( count( $brixly_tabs ) ): ?>
        <nav class="nav-tab-wrapper wp-clearfix">
			<?php foreach ( $brixly_tabs as $id => $tab ) : ?>
                <a class="nav-tab <?php echo ( $brixly_current_tab === $id ) ? 'nav-tab-active' : '' ?>"
                   href="<?php echo esc_attr( add_query_arg( array( 'current_tab' => $id ), $brixly_url ) ); ?>">
					<?php echo esc_html( $tab['title'] ); ?>
                </a>
			<?php endforeach; ?>
        </nav>
	<?php endif; ?>
    </div>
	<?php if ( $brixly_tab_partial ): ?>
        <div class="brixly-admin-page--body brixly-admin-page-spacing">
            <div class="brixly-admin-page--content">
                <div class="brixly-admin-page--tab">
                    <div class="brixly-admin-page--tab-<?php echo esc_attr( $brixly_current_tab ); ?>">
						<?php \BrixlyWP\Theme\View::make( $brixly_tab_partial,
							\BrixlyWP\Theme\Core\Hooks::brixly_apply_filters( "info_page_data_tab_{$brixly_current_tab}",
								array() ) ); ?>
                    </div>
                </div>

            </div>
            <div class="brixly-admin-page--sidebar">
                <?php \BrixlyWP\Theme\View::make('admin/sidebar') ?>
            </div>
        </div>
	<?php endif; ?>
</div>


