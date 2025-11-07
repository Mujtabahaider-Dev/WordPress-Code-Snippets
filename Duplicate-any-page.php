// Add Duplicate link to admin actions
function mh_duplicate_page_post_link( $actions, $post ) {
    if ( current_user_can( 'edit_posts' ) ) {
        $url = wp_nonce_url(
            admin_url( 'admin.php?action=mh_duplicate_page_post&post=' . $post->ID ),
            basename(__FILE__),
            'mh_duplicate_nonce'
        );
        $actions['duplicate'] = '<a href="' . $url . '">Duplicate</a>';
    }
    return $actions;
}
add_filter( 'post_row_actions', 'mh_duplicate_page_post_link', 10, 2 );
add_filter( 'page_row_actions', 'mh_duplicate_page_post_link', 10, 2 );

// Handle duplicate creation
function mh_duplicate_page_post() {
    if (
        ! ( isset($_GET['post'], $_GET['mh_duplicate_nonce']) &&
        wp_verify_nonce( $_GET['mh_duplicate_nonce'], basename(__FILE__) ) )
    ) {
        wp_die( 'Security check failed' );
    }

    $post_id = absint( $_GET['post'] );
    $post = get_post( $post_id );

    if ( ! $post ) {
        wp_die( 'Post not found' );
    }

    $new_post_data = array(
        'post_title'     => $post->post_title . ' Copy',
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_status'    => 'draft',
        'post_type'      => $post->post_type,
        'post_author'    => get_current_user_id()
    );

    $new_post_id = wp_insert_post( $new_post_data );

    // Copy Post Meta
    $post_meta = get_post_meta( $post_id );
    foreach ( $post_meta as $key => $values ) {
        foreach ( $values as $value ) {
            add_post_meta( $new_post_id, $key, maybe_unserialize( $value ) );
        }
    }

    // Copy Taxonomies (categories, tags, etc.)
    $taxonomies = get_object_taxonomies( $post->post_type );
    foreach ( $taxonomies as $taxonomy ) {
        $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'ids' ] );
        wp_set_object_terms( $new_post_id, $terms, $taxonomy );
    }

    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
}
add_action( 'admin_action_mh_duplicate_page_post', 'mh_duplicate_page_post' );
