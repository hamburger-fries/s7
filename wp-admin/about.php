<?php
/**
 * About This Version administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

$title = __( 'About' );

list( $display_version ) = explode( '-', $wp_version );

// Temporary 3.8 hack: We want to use user-profile for the color schemes but don't need the heavy zxcvbn.
wp_deregister_script( 'zxcvbn-async' );
wp_register_script( 'zxcvbn-async', false );
wp_enqueue_script( 'user-profile' );

include( ABSPATH . 'wp-admin/admin-header.php' );
?>
<div class="wrap about-wrap">

<h1><?php printf( __( 'Welcome to WordPress&nbsp;%s' ), $display_version ); ?></h1>

<div class="about-text"><?php printf( __( 'Thank you for updating to WordPress %s, the most beautiful WordPress&nbsp;yet.' ), $display_version ); ?></div>

<div class="wp-badge"><?php printf( __( 'Version %s' ), $display_version ); ?></div>

<h2 class="nav-tab-wrapper">
	<a href="about.php" class="nav-tab nav-tab-active">
		<?php _e( 'What&#8217;s New' ); ?>
	</a><a href="credits.php" class="nav-tab">
		<?php _e( 'Credits' ); ?>
	</a><a href="freedoms.php" class="nav-tab">
		<?php _e( 'Freedoms' ); ?>
	</a>
</h2>

<div class="changelog point-releases">
	<h3><?php echo _n( 'Maintenance and Security Release', 'Maintenance and Security Releases', 41 ); ?></h3>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			_n(
				'<strong>Version %1$s</strong> addressed a security issue.',
				'<strong>Version %1$s</strong> addressed some security issues.',
				1
			),
			'3.8.41'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.41' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.40'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.40' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.39'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.39' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed one security issue.' ),
			'3.8.38'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.38' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.37'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.37' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed one security issue.' ),
			'3.8.36'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.36' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.35'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.35' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.34'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.34' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.33'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.33' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed one security issue.' ),
			'3.8.32'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.32' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.31'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.31' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed some security issues.' ),
			'3.8.30'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.30' )
			)
		);
		?>
	</p>
	<p>
		<?php
		printf(
			/* translators: %s: WordPress version number */
			__( '<strong>Version %s</strong> addressed a security issue.' ),
			'3.8.29'
		);
		?>
		<?php
		printf(
			/* translators: %s: HelpHub URL */
			__( 'For more information, see <a href="%s">the release notes</a>.' ),
			sprintf(
				/* translators: %s: WordPress version */
				esc_url( __( 'https://wordpress.org/support/wordpress-version/version-%s/' ) ),
				sanitize_title( '3.8.29' )
			)
		);
		?>
	</p>
	<p>
		<?php
		/* translators: %s: WordPress version number */
		printf( __( '<strong>Version %s</strong> addressed some security issues.' ), '3.8.28' );
		?>
		<?php
		/* translators: %s: Codex URL */
		printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.28' );
		?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 1 ), '3.8.27' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.27' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 2 ), '3.8.26' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.26' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 1 ), '3.8.25' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.25' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 4 ), '3.8.24' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.24' ); ?>
	</p>
	<p><?php printf( __( '<strong>Version %s</strong> addressed one security issue.' ), '3.8.23' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.23' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 7 ), '3.8.22' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.22' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
			'<strong>Version %1$s</strong> addressed some security issues.', 5 ), '3.8.21' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.21' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed %2$s bug.',
			'<strong>Version %1$s</strong> addressed %2$s bugs.', 1 ), '3.8.20', number_format_i18n( 1 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.20' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 5 ), '3.8.19' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.19' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 3 ), '3.8.18' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.18' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 8 ), '3.8.17' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.17' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 2 ), '3.8.16' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.16' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 9 ), '3.8.15' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.15' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 6 ), '3.8.14' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.14' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 2 ), '3.8.13' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.13' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 1 ), '3.8.12' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.12' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.', 2 ), '3.8.11', number_format_i18n( 2 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.11' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.', 2 ), '3.8.10', number_format_i18n( 2 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.10' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 2 ), '3.8.9' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.9' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.', 3 ), '3.8.8', number_format_i18n( 3 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.8' ); ?>
	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed %2$s bug.',
         '<strong>Version %1$s</strong> addressed %2$s bugs.', 1 ), '3.8.7', number_format_i18n( 1 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.7' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 8 ), '3.8.6' ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.6' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 8 ), '3.8.5', number_format_i18n( 8 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.5' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.', 5 ), '3.8.4', number_format_i18n( 5 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.4' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed %2$s bug.',
		'<strong>Version %1$s</strong> addressed %2$s bugs.', 2 ), '3.8.3', number_format_i18n( 2 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.3' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.', 9 ), '3.8.2', number_format_i18n( 9 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.2' ); ?>
 	</p>
	<p><?php printf( _n( '<strong>Version %1$s</strong> addressed %2$s bug.',
		'<strong>Version %1$s</strong> addressed %2$s bugs.', 31 ), '3.8.1', number_format_i18n( 31 ) ); ?>
		<?php printf( __( 'For more information, see <a href="%s">the release notes</a>.' ), 'https://codex.wordpress.org/Version_3.8.1' ); ?>
 	</p>
</div>

<div class="changelog">
	<h2 class="about-headline-callout"><?php _e( 'Introducing a modern new&nbsp;design' ); ?></h2>
	<img class="about-overview-img" src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/overview.png?1" />
	<div class="feature-section col three-col about-updates">
		<div class="col-1">
			<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/aesthetics.png?1" />
			<h3><?php _e( 'Modern aesthetic' ); ?></h3>
			<p><?php _e( 'The new WordPress dashboard has a fresh, uncluttered design that embraces clarity and simplicity.' ); ?></p>
		</div>
		<div class="col-2">
			<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/typography.png?1" />
			<h3><?php _e( 'Clean typography' ); ?></h3>
			<p><?php _e( 'The Open Sans typeface provides simple, friendly text that is optimized for both desktop and mobile viewing. It&#8217;s even open source, just like WordPress.' ); ?></p>
		</div>
		<div class="col-3 last-feature">
			<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/contrast.png?1" />
			<h3><?php _e( 'Refined contrast' ); ?></h3>
			<p><?php _e( 'We think beautiful design should never sacrifice legibility. With superior contrast and large, comfortable type, the new design is easy to read and a pleasure to navigate.' ); ?></p>
		</div>
	</div>
</div>

<hr>

<div class="changelog">
	<div class="feature-section col two-col">
		<div>
			<h3><?php _e( 'WordPress on every&nbsp;device' ); ?></h3>
			<p><?php _e( 'We all access the internet in different ways. Smartphone, tablet, notebook, desktop &mdash; no matter what you use, WordPress will adapt and you&#8217;ll feel right at home.' ); ?></p>
			<h4><?php _e( 'High definition at high&nbsp;speed' ); ?></h4>
			<p><?php _e( 'WordPress is sharper than ever with new vector-based icons that scale to your screen. By ditching pixels, pages load significantly faster, too.' ); ?></p>
		</div>
		<div class="last-feature about-colors-img">
			<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/colors.png?1" />
		</div>
	</div>
</div>

<hr>

<?php
global $_wp_admin_css_colors;
$new_colors = array( 'fresh', 'light', 'blue', 'midnight', 'sunrise', 'ectoplasm', 'ocean', 'coffee' );
$_wp_admin_css_colors = array_intersect_key( $_wp_admin_css_colors, array_fill_keys( $new_colors, true ) );

if ( count( $_wp_admin_css_colors ) > 1 && has_action( 'admin_color_scheme_picker' ) ) : ?>
<div class="changelog about-colors">
	<div class="feature-section col one-col">
		<div>
			<h3><?php _e( 'Pick a color' ); ?></h3>
			<p><?php _e( 'We&#8217;ve included eight color schemes so you can pick your favorite. Choose from any of them below to change it instantly.' ); ?>
				<?php
				/** This action is documented in wp-admin/user-edit.php */
				do_action( 'admin_color_scheme_picker' );
				?>
			<p><?php printf( __( 'To change your color scheme later, just <a href="%1$s">visit your profile</a>.' ), get_edit_profile_url( get_current_user_id() ) ); ?></p>
		</div>
	</div>
</div>

<hr>
<?php endif; ?>

<div class="changelog">
	<div class="feature-section col two-col">
		<div>
			<h3><?php _e( 'Refined theme management' ); ?></h3>
			<p><?php _e( 'The new themes screen lets you survey your themes at a glance. Or want more information? Click to discover more. Then sit back and use your keyboard&#8217;s navigation arrows to flip through every theme you&#8217;ve got.' ); ?></p>
			<h4><?php _e( 'Smoother widget experience' ); ?></h4>
			<p><?php _e( 'Drag-drag-drag. Scroll-scroll-scroll. Widget management can be complicated. With the new design, we&#8217;ve worked to streamline the widgets&nbsp;screen.' ); ?></p>
			<p><?php _e( 'Have a large monitor? Multiple widget areas stack side-by-side to use the available space. Using a tablet? Just tap a widget to add it.' ); ?></p>
		</div>
		<div class="last-feature about-themes-img">
			<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/themes.png?1" />
		</div>
	</div>
</div>

<hr>

<div class="changelog about-twentyfourteen">
	<h2 class="about-headline-callout"><?php _e( 'Twenty Fourteen, a sleek new magazine&nbsp;theme' ); ?></h2>
	<img src="<?php echo is_ssl() ? 'https://' : '//s.'; ?>wordpress.org/images/core/3.8/twentyfourteen.jpg?1" />

	<div class="feature-section col one-col center-col">
		<div>
			<h3><?php _e( 'Turn your blog into a&nbsp;magazine' ); ?></h3>
			<p><?php _e( 'Create a beautiful magazine-style site with WordPress and Twenty Fourteen. Choose a grid or a slider to display featured content on your homepage. Customize your site with three widget areas or change your layout with two page templates.' ); ?></p>
			<p><?php _e( 'With a striking design that does not compromise our trademark simplicity, Twenty Fourteen is our most intrepid default theme yet.' ); ?></p>
		</div>
	</div>
</div>

<hr>

<div class="return-to-dashboard">
	<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
	<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>"><?php
		is_multisite() ? _e( 'Return to Updates' ) : _e( 'Return to Dashboard &rarr; Updates' );
	?></a> |
	<?php endif; ?>
	<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php
		is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home' ) : _e( 'Go to Dashboard' ); ?></a>
</div>

</div>
<?php

include( ABSPATH . 'wp-admin/admin-footer.php' );

// These are strings we may use to describe maintenance/security releases, where we aim for no new strings.
return;

_n_noop( 'Maintenance Release', 'Maintenance Releases' );
_n_noop( 'Security Release', 'Security Releases' );
_n_noop( 'Maintenance and Security Release', 'Maintenance and Security Releases' );

/* translators: 1: WordPress version number. */
_n_noop( '<strong>Version %1$s</strong> addressed a security issue.',
         '<strong>Version %1$s</strong> addressed some security issues.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. */
_n_noop( '<strong>Version %1$s</strong> addressed %2$s bug.',
         '<strong>Version %1$s</strong> addressed %2$s bugs.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. Singular security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bugs.' );

/* translators: 1: WordPress version number, 2: plural number of bugs. More than one security issue. */
_n_noop( '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
         '<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.' );

__( 'For more information, see <a href="%s">the release notes</a>.' );

/* translators: 1: WordPress version number, 2: Link to update WordPress */
__( 'Important! Your version of WordPress (%1$s) is no longer supported, you will not receive any security updates for your website. To keep your site secure, please <a href="%2$s">update to the latest version of WordPress</a>.' );

/* translators: 1: WordPress version number, 2: Link to update WordPress */
__( 'Important! Your version of WordPress (%1$s) will stop receiving security updates in the near future. To keep your site secure, please <a href="%2$s">update to the latest version of WordPress</a>.' );
