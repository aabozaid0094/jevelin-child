<li role="presentation" class="<?php if($i==0) echo "active" ;?>">
    <a href="#<?php echo get_the_ID(); ?>" aria-controls="<?php echo get_the_ID(); ?>" role="tab" data-toggle="tab">
        <div class="post-icon-title">
            <?php if (get_field('icon')) { ?>
                <div class="post-icon-wrapper">
                    <div class="post-icon">
                        <?php echo wp_get_attachment_image( get_field('icon'), 'medium'); ?>
                    </div>
                </div>
            <?php } ?>
            <<?php echo $title_tag; ?> class="post-title" href="<?php echo get_the_permalink(); ?>">
                <?php echo get_the_title(); ?>
            </<?php echo $title_tag; ?>>
        </div>
    </a>
</li>