<?php if (get_the_title()) { ?>
    <li class="post-list-item">
        <i class="fa fa-bookmark" aria-hidden="true"></i>
        <a href="<?php echo get_the_permalink(); ?>">
            <<?php echo $title_tag; ?> class="post-title" href="<?php echo get_the_permalink(); ?>">
                <?php echo get_the_title(); ?>
            </<?php echo $title_tag; ?>>
        </a>
    </li>
<?php } ?>