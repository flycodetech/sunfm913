<?php
/**
 * The template to display the background video in the header
 *
 * @package VERSE
 * @since VERSE 1.0.14
 */
$verse_header_video = verse_get_header_video();
$verse_embed_video  = '';
if ( ! empty( $verse_header_video ) && ! verse_is_from_uploads( $verse_header_video ) ) {
	if ( verse_is_youtube_url( $verse_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $verse_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php verse_show_layout( verse_get_embed_video( $verse_header_video ) ); ?></div>
		<?php
	}
}
