<div class="post-container-wrapper">
    <div class="<?php echo ($columns==1) ? 'container-fluid' : '' ; ?>">
        <?php if("testimonial" == $post_type){
			echo '<div class="testimonial-item testimonial-item-' . get_the_ID() . ' equalized-item">';
				if (get_post_meta(get_the_ID(), 'quote', true)) {
					echo '<div class="testimonial-quote">' .  get_post_meta(get_the_ID(), 'quote', true) . '</div>';
				}
				echo '<div class="testimonial-person">';
					echo '<div class="testimonial-image">' . get_the_post_thumbnail(get_the_ID(), "thumbnail") . '</div>';
					echo '<div class="testimonial-textual-info">';
						echo '<h4 class="testimonial-title">' . get_the_title() . '</h4>';
						if (get_post_meta(get_the_ID(), 'info', true)) {
							echo '<div class="testimonial-info">' .  get_post_meta(get_the_ID(), 'info', true) . '</div>';
						}
						if (get_post_meta(get_the_ID(), 'stars_count', true)) {
							echo '<div class="testimonial-stars active' . get_post_meta(get_the_ID(), 'stars_count', true) . '">' . str_repeat('<i class="fa fa-star"></i>', 5) . '</div>'; 
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}elseif ("clinic" == $post_type) {
			echo '<div class="clinic-item clinic-item-' . get_the_ID() . ' equalized-item">';
                echo '<h4 class="clinic-title">' . get_the_title() . '</h4>';
                $clinic_location = get_post_meta(get_the_ID(), 'location', true);
                $clinic_location_url = get_post_meta(get_the_ID(), 'location_url', true);
				if ($clinic_location) {
                    echo '<div class="clinic-location">';
                        echo ($clinic_location_url) ? '<a href="' . $clinic_location_url . '">' : '';
                            echo $clinic_location;
                        echo ($clinic_location_url) ? '</a>' : '';
                    echo '</div>';
				}
                $clinic_phone = get_post_meta(get_the_ID(), 'phone', true);
                $clinic_phone_url = get_post_meta(get_the_ID(), 'phone_url', true);
				if ($clinic_phone) {
					echo '<div class="clinic-phone">';
                        echo ($clinic_phone_url) ? '<a href="' . $clinic_phone_url . '">' : '';
                            echo $clinic_phone;
                        echo ($clinic_phone_url) ? '</a>' : '';
                    echo '</div>';
				}
			echo '</div>';
		}else{ ?>
        <div class="post-item">
            <div class="post-image-wrapper">
                <?php if (get_post_meta(get_the_ID(), 'item_image', true)) { ?>
                    <div class="post-image">
                        <?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'item_image', true), $image_size, false, array('class'=>'post-item-image') ); ?>
                    </div>
                <?php } elseif (get_the_post_thumbnail()) { ?>
                    <div class="post-image">
                        <div class="post-image-overlay"></div>
                        <?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?>
                        <a class="post-more" href="<?php echo get_the_permalink(); ?>"><?php echo __("Read More", "jevelinchild"); ?></a>
                    </div>
                <?php } ?>
                <?php if (get_post_meta(get_the_ID(), 'icon', true)) { ?>
                    <div class="post-icon">
                        <?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'icon', true), 'thumbnail', false, array('class'=>'original-image') ); ?>
                        <?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'second_icon', true), 'thumbnail', false, array('class'=>'hover-image') ); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="post-info equalized-item-alt">
                <div class="post-meta-pre">
                    <?php if (get_the_author()) { ?>
                        <div class="post-author">
                            <?php echo get_the_author(); ?>
                        </div>
                    <?php } ?>
                    <?php if (getPostViews(get_the_ID())) { ?>
                        <div class="post-views">
                            <?php echo getPostViews(get_the_ID()) . " " . __("View(s)", "jevelinchild"); ?>
                        </div>
                    <?php } ?>
                    <?php if (get_the_content()) { ?>
                        <div class="content-minutes">
                            <?php echo content_in_minutes_text(get_the_ID()); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="post-meta">
                    <?php
                    if ($taxonomies = get_post_taxonomies()) {
                        $terms_names = ''; $terms = get_the_terms(get_the_ID(), $taxonomies[0]);
                        $length = count($terms);
                        foreach($terms as $index => $term){
                            $separator = ($index==$length-1)?'':', ';
                            $terms_names .= $term->name . $separator; 
                            unset($term);
                        }
                        ?>
                        <div class="post-type">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            <span><?php echo $terms_names; ?></span>
                        </div>
                    <?php } ?>
                    <div class="post-comments">
                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                        <span><?php echo get_comments_number(); ?></span>
                    </div>
                </div>
                <?php if (get_the_title()) { ?>
                    <a class="post-title-link" href="<?php echo get_the_permalink(); ?>">
                        <<?php echo $title_tag; ?> class="post-title equalized-item">
                            <?php echo get_the_title(); ?>
                        </<?php echo $title_tag; ?>>
                    </a>
                <?php } ?>
                <div class="post-date">
                    <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                        <div class="day">
                            <?php echo get_the_date("d"); ?>
                        </div>
                        <div class="month">
                            <?php echo get_the_date("F"); ?>
                        </div>
                    </time>
                </div>
                <?php if (get_the_excerpt()) { ?>
                    <div class="post-excerpt">
                        <?php echo get_the_excerpt(); ?>
                    </div>
                <?php } ?>
                <a class="post-more-icon" href="<?php echo get_the_permalink(); ?>">
                    <span><?php echo __("Read More", "jevelinchild"); ?></span>
                    <?php echo $more_icon; ?>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>