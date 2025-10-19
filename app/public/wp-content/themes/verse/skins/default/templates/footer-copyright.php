<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$verse_copyright_scheme = verse_get_theme_option( 'copyright_scheme' );
if ( ! empty( $verse_copyright_scheme ) && ! verse_is_inherit( $verse_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $verse_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$verse_copyright = verse_get_theme_option( 'copyright' );
			if ( ! empty( $verse_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$verse_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $verse_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$verse_copyright = verse_prepare_macros( $verse_copyright );
				// Display copyright
				echo wp_kses( nl2br( $verse_copyright ), 'verse_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
