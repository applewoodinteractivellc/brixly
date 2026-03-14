<div class="social-icon-container d-inline-flex">
  <a href="<?php echo esc_html(\BrixlyWP\Theme\View::getData( 'link_value' )); ?>">
    <div class="icon-container h-social-icon">
      <div class="h-icon-svg" style="width: 100%; height: 100%;">
        <?php $icon = \BrixlyWP\Theme\View::getData( 'icon' ); if (isset($icon['content'])) echo $icon['content'] ?>
      </div>
    </div>
  </a>
</div>
