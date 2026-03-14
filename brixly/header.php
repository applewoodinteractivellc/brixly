<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php brixly_theme()->get( 'css' )->render(); ?>
</head>

<body id="brixly" <?php body_class(); ?>>

<div class="site" id="page-top">
	<?php brixly_theme()->get( 'header' )->render(); ?>

