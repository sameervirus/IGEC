<?php
/**
 * hooks.
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

/**
 * Extras
 */
add_filter( 'excerpt_length', 'powernodewt_excerpt_length', 10 );

/*
 * Main Wrapper
 */
add_action( 'powernode_before_main_content', 'powernodewt_start_wrapper', 10 );
add_action( 'powernode_after_main_content', 'powernodewt_end_wrapper', 10 );

/*
 * Blog/Post
 */
add_action( 'powernode_before_loop_post', 'powernodewt_before_loop_post', 10 );
add_action( 'powernode_after_loop_post', 'powernodewt_after_loop_post', 10 );
add_action( 'powernode_after_loop_post', 'powernodewt_after_loop_post_reset', 999 );
add_action( 'powernode_loop_pagination', 'powernodewt_blog_loop_post_pagination', 10 );

add_action( 'powernode_post_header', 'powernodewt_post_title', 20 );
add_action( 'powernode_post_header', 'powernodewt_post_meta', 30 );

add_action( 'powernode_single_post', 'powernodewt_post_header',	10 );
add_action( 'powernode_single_post', 'powernodewt_post_thumbnail',	20 );
add_action( 'powernode_single_post', 'powernodewt_post_content',	30 );
add_action( 'powernode_single_post', 'powernodewt_single_post_author_info',	40 );
add_action( 'powernode_single_post', 'powernodewt_post_tags', 50 );
add_action( 'powernode_single_post', 'powernodewt_post_social_links', 60 );
add_action( 'powernode_single_post', 'powernodewt_single_post_next_prev_links', 70 );
add_action( 'powernode_single_post', 'powernodewt_single_post_comments', 80 );


/*
 * Page
 */
add_action( 'powernodewt_page_content', 'powernodewt_template_page_content', 10 );

