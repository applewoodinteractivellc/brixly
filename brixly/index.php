<?php
get_header();

if ( is_front_page() ) {
    do_action( 'brixly_builder_sections' );
} else {
    brixly_theme()->get( 'main' )->render();
}

get_footer();
