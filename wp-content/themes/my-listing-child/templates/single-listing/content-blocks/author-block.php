<?php
/**
 * Template for rendering an `author` block in single listing page.
 *
 * @since 1.0
 */
if ( ! defined('ABSPATH') ) {
    exit;
}

$author = $listing->get_author();
if ( ! ( $author instanceof \MyListing\Src\User && $author->exists() ) ) {
    return;
}

$social_links = $author->get_social_links();
$links = [];
if ( ! empty( $social_links ) ) {
    $links = array_map( function( $network ) {
        return [
            'name' => $network['name'],
            'icon' => sprintf( '<i class="%s"></i>', esc_attr( $network['icon'] ) ),
            'link' => $network['link'],
            'color' => $network['color'],
            'text_color' => '#fff',
        ];
    }, $social_links );
}
?>

<div class="<?php echo esc_attr( $block->get_wrapper_classes() ) ?>" id="<?php echo esc_attr( $block->get_wrapper_id() ) ?>">
    <div class="element related-listing-block">
        <div class="pf-head">
            <div class="title-style-1">
                <i class="<?php echo esc_attr( $block->get_icon() ) ?>"></i>
                <h5><?php echo esc_html( $block->get_title() ) ?></h5>
            </div>
        </div>
        <div class="pf-body">
            <div class="event-host">
                <a href="<?php echo esc_url( $author->get_link() ) ?>">
                    <div class="avatar">
                        <img src="<?php echo esc_url( $author->get_avatar() ) ?>">
                    </div>
                    <div class="host-name">
                        <?php
                        $thePostID = $listing->get_id();
                        $author_id = get_post_field( 'post_author', $thePostID );
                        $FName = get_user_meta( $author_id, 'first_name', true );
                        $LName = get_user_meta( $author_id, 'last_name', true );
                        if (strlen($FName)) {
                            if (strlen($LName)) {
                                echo $FName." ".$LName;
                            }
                        } else {
                            echo esc_attr($listing->author->get_name());
                        } ?>
                        <?php if ( $author_about = $author->get_description() ) : ?>
                            <div class="author-bio-listing">
                                <?php echo wpautop( $author_about );?>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php if ( $links ) : ?>
                <?php mylisting_locate_template(
                    'templates/single-listing/content-blocks/lists/outlined-list.php', [
                    'items' => $links
                ] ) ?>
            <?php endif; ?>
        </div>
    </div>
</div>