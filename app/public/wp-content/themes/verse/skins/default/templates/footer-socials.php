<?php
/**
 * The template to display the socials in the footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */


// Socials
if ( verse_is_on( verse_get_theme_option( 'socials_in_footer' ) ) ) {
	$verse_output = verse_get_socials_links();
	if ( '' != $verse_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php verse_show_layout( $verse_output ); ?>
			</div>
		</div>
		<?php
	}
}
