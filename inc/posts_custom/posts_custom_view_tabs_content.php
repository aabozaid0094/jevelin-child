<div role="tabpanel" class="tab-pane<?php if($i==0) echo " active in" ;?>" id="<?php echo get_the_ID(); ?>">
    <<?php echo $title_tag; ?> class="post-title" href="<?php echo get_the_permalink(); ?>">
        <?php echo get_the_title(); ?>
    </<?php echo $title_tag; ?>>
    
    <?php if (get_the_excerpt()) { ?>
        <div class="post-excerpt equalized-item-alt">
            <?php echo get_the_excerpt(); ?>
        </div>
    <?php } ?>
            
    <a class="post-more-icon" href="<?php echo get_the_permalink(); ?>">
        <span><?php echo __("Read More", "jevelinchild"); ?></span>
        <?php echo $more_icon; ?>
    </a>
</div>