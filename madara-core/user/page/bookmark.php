<?php
	/**
	 * The Template for Bookmarked section (list of bookmarked mangas) in User Settings page
	 *
	 * This template can be overridden by copying it to your-child-theme/madara-core/user/bookmark.php
	 *
	 * MODIFIED VERSION 3.0 (Stable):
	 * - Correctly labels the "Last Read" chapter link.
	 * - Restores the theme's default display of the actual "Latest Chapters".
	 * - Applies a more compact and scannable design.
	 *
	 * @package Madara
	 * @version 1.7.2.2 (Customized)
	 */

	use App\Madara;

	if ( ! is_user_logged_in() ) {
		return;
	}

	$wp_manga_functions = madara_get_global_wp_manga_functions();
	$user_id            = get_current_user_id();
	$bookmarks          = $wp_manga_functions->get_bookmarked_mangas( $user_id, Madara::getOption( 'manga_bookmark_list_orderby', '' ) );
	$reading_style      = $wp_manga_functions->get_reading_style();
	$reading_style      = ! empty( $reading_style ) ? $reading_style : 'paged';
?>

<style>
    .list-bookmark th {
        font-size: 14px;
    }
    .list-bookmark td {
        padding: 10px 8px !important;
        vertical-align: middle;
    }
    .list-bookmark .item-thumb img {
        width: 50px; /* smaller image */
        height: 75px;
        object-fit: cover;
    }
    .list-bookmark .post-title h3 {
        font-size: 16px; /* smaller title */
        margin-bottom: 5px;
    }
    .list-bookmark .chapter, .list-bookmark .list-chapter > div {
        font-size: 13px; /* smaller chapter text */
    }
    .list-bookmark .action a {
        font-size: 24px;
    }
    .list-bookmark .item-infor .chapter span {
        font-weight: 600;
        color: #333;
    }
</style>

<table class="table table-hover list-bookmark">
	<thead>
	<tr>
		<th><?php esc_html_e( 'Manga', 'madara' ); ?></th>
		<th><?php esc_html_e( 'Edit', 'madara' ); ?></th>
	</tr>
	</thead>
	<tbody>

	<?php if ( ! empty( $bookmarks ) ) {
		$order = Madara::getOption( 'manga_bookmark_list_order', 'oldest_first' );
		if ( $order == 'newest_first' ) {
			$bookmarks = array_reverse( $bookmarks );
		}
		foreach ( $bookmarks as $bookmark ) {

			$post = isset( $bookmark['post'] ) ? $bookmark['post'] : get_post( intval( $bookmark['id'] ) );

			if ( $post == null || $post->post_status !== 'publish' ) {
				continue;
			}

			$post_id = $bookmark['id'];

			//get bookmarked chapter (this is the last chapter the user read)
			$chapter = null;
			if ( class_exists( 'WP_MANGA' ) && ! empty( $bookmark['c'] ) && ! is_array( $bookmark['c'] ) ) {
				$wp_manga_chapter = madara_get_global_wp_manga_chapter();
				$chapter          = $wp_manga_chapter->get_chapter_by_id( $post->ID, $bookmark['c'] );
			}

			$permalink = get_the_permalink( $post_id );
			$title     = get_the_title( $post_id );

			if ( class_exists( 'WP_MANGA_USER_ACTION' ) ) {
				global $wp_manga_user_actions;
				$notify_num = $wp_manga_user_actions->get_user_notify_num( $user_id, $bookmark['id'] );
			}
			?>
			<tr>
				<td>
					<div class="mange-name">
						<div class="item-thumb">
							<?php if ( has_post_thumbnail( $post_id ) ) { ?>
								<a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $title ); ?>">
									<?php echo madara_thumbnail( array( 50, 75 ), $post_id ); // Using smaller thumbnail size ?>
								</a>
							<?php } ?>

							<?php if ( ! empty( $notify_num ) ) { ?>
								<div class="c-notifications">
									<?php echo esc_html( $notify_num ); ?>
								</div>
							<?php } ?>
						</div>
						<div class="item-infor">
							<div class="post-title">
								<?php if ( ! empty( $title ) ) { ?>
									<h3>
										<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_attr( $title ); ?></a>
									</h3>
								<?php } ?>
							</div>

							<?php if ( ! empty( $chapter ) ) {
								$chapter_url = $wp_manga_functions->build_chapter_url( $post_id, $chapter['chapter_slug'], $reading_style );
								?>
								<div class="chapter">
                                    <span><?php echo esc_html__( 'Last Read: ', 'madara' ); ?><a href="<?php echo esc_url( $chapter_url ); ?>"><?php echo( esc_html( $chapter['chapter_name'] ) ? esc_html( $chapter['chapter_name'] ) : '' ); ?></a></span>
								</div>

							<?php } ?>

                            <div class="list-chapter">
								<?php
									$wp_manga_functions->manga_meta( $post_id );
								?>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="action">
						<div class="checkbox">
							<input id="<?php echo esc_attr( $post_id ); ?>" class="bookmark-checkbox" value="<?php echo esc_attr( $post_id ); ?>" type="checkbox">
							<label for="<?php echo esc_attr( $post_id ); ?>"></label>
						</div>
						<a class="wp-manga-delete-bookmark" href="javascript:void(0)" data-post-id="<?php echo esc_attr( $post_id ); ?>"><i class="icon ion-ios-close"></i></a>
					</div>
				</td>
			</tr>
			<?php
		}
	} ?>
	<?php if ( ! empty( $bookmarks ) ) { ?>

		<tr>
			<td colspan="2">
				<div class="remove-all float-right">
					<div class="checkbox">
						<input id="checkall" type="checkbox">
						<label for="checkall"><?php esc_html_e( 'Check all', 'madara' ); ?></label>
					</div>
					<button type="button" id="delete-bookmark-manga" class="btn btn-default"><?php esc_html_e( 'Delete', 'madara' ); ?></button>
				</div>
			</td>
		</tr>

	<?php } else { ?>
		<tr>
			<td colspan="2"> <?php esc_html_e( 'No Manga Bookmarked', 'madara' ); ?> </td>
		</tr>
	<?php } ?>
	</tbody>
</table>