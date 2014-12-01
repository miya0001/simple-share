<?php
/*
Plugin Name: Simple Share
Version: 0.8.1
Description: You can place share buttons just activating this plugin.
Author: Takayuki Miyauchi
Author URI: http://firegoby.jp/
Plugin URI: http://github.com/miya0001/simple-share
Text Domain: simple-share
Domain Path: /languages
*/

$simple_share = new Simple_Share();
$simple_share->register();

class Simple_Share {

	public function register()
	{
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	public function plugins_loaded()
	{
		add_filter( 'the_content', array( $this, 'the_content' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

		add_action( 'simple_share_footer', array( $this, 'twitter_script' ) );
		add_action( 'simple_share_footer', array( $this, 'facebook_script' ) );
		add_action( 'simple_share_footer', array( $this, 'google_script' ) );
		add_action( 'simple_share_footer', array( $this, 'hatena_script' ) );
	}


	public function wp_enqueue_scripts()
	{
		/*
		* If you want to style only your theme. You can stop style of this plugin.
		*
		* add_filter( 'simple_share_style', "__return_false" );
		*/

		$style = apply_filters( 'simple_share_style', plugins_url( 'css/simple-share.css', __FILE__ ) );
		if ( $style ) {
			wp_enqueue_style(
				'simple_share',
				$style
			);
		}
	}


	public function the_content( $contents )
	{
		if ( ! is_singular() ) {
			return $contents;
		}

		$buttons = $this->get_share_buttons();
		$share = '<ul class="simple-share">';
		foreach ( $buttons as $key => $btn ) {
			$share .= '<li class="simple-share-button simple-share-' . esc_attr( $key ) . '">';
			$share .= sprintf( $btn, esc_attr( get_permalink() ), esc_attr( get_the_title() ) );
			$share .= '</li>';
		}
		$share .= '</ul>';

		return apply_filters( 'simple_share_the_content', $share . $contents, $share, $contents );
	}

	public function get_share_buttons()
	{
		$share_buttons = array(
			'twitter' => '<a class="twitter-share-button" href="https://twitter.com/share" data-lang="en" data-count="vertical">Tweet</a>',
			'facebook' => '<div class="fb-like" data-href="%1$s" data-send="false" data-layout="box_count" data-show-faces="false"></div>',
			'google' => '<div class="g-plusone" data-size="tall"></div>',
		);

		if ( apply_filters( 'simple_share_need_hatena', 'ja' === get_locale() ) ) {
			$share_buttons['hatena'] = '<a href="http://b.hatena.ne.jp/entry/%1$s" class="hatena-bookmark-button" data-hatena-bookmark-title="%2$s" data-hatena-bookmark-layout="vertical-balloon" data-hatena-bookmark-lang="en"><img src="//b.st-hatena.com/images/entry-button/button-only@2x.png" width="20" height="20" style="border: none;" /></a>';
		}

		return apply_filters( 'simple_share_get_share_buttons', $share_buttons );
	}


	public function wp_footer()
	{
		if ( ! is_singular() ) {
			return;
		}

		if ( is_singular() ) {
			$mobile_footer = '<div id="simple-share-mobile-footer-wrap"></div>';
			$mobile_footer .= '<div id="simple-share-mobile-footer">';
			$mobile_footer .= '<div class="simple-share-mobile-footer-button simple-share-twitter"><a href="https://twitter.com/intent/tweet?text='.urlencode( esc_attr( get_the_title() ).' '.esc_url( get_permalink() ) ).'">Share on Twitter</a></div>';
			$mobile_footer .= '<div class="simple-share-mobile-footer-button simple-share-facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode( esc_url( get_permalink() ) ).'">Share on Facebook</a></div>';
			$mobile_footer .= '</div>';

			echo apply_filters( 'simple_share_mobile_footer', $mobile_footer );
			do_action( 'simple_share_footer' );
		}
	}

	public function twitter_script()
	{
		/*
		* If you would have conflicts with other plugin, you can stop here like below.
		*
		* remove_action( 'simple_share_footer', array( $simple_share, 'twitter_script' ) );
		*/

		?>
			<script type="text/javascript">// <![CDATA[
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			// ]]></script>
		<?php
	}

	public function hatena_script()
	{
		/*
		* If you would have conflicts with other plugin, you can stop here like below.
		*
		* remove_action( 'simple_share_footer', array( $simple_share, 'hatena_script' ) );
		*/

		$btns = $this->get_share_buttons();
		if ( isset( $btns['hatena'] ) && $btns['hatena'] ) {
			echo '<script type="text/javascript" src="//b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>';
		}
	}

	public function facebook_script()
	{
		/*
		 * If you would have conflicts with other plugin, you can stop here like below.
		 *
		 * remove_action( 'simple_share_footer', array( $simple_share, 'facebook_script' ) );
		 */

		// Check if the Facebook JavaScript SDK is already registered to avoid double load
		if ( wp_script_is( 'facebook-jssdk' ) ) {
			return;
		}

		?>
			<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/sdk.js#version=v2.0&xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
		<?php
	}


	public function google_script()
	{
		/*
		* If you would have conflicts with other plugin, you can stop here like below.
		*
		* remove_action( 'simple_share_footer', array( $simple_share, 'google_script' ) );
		*/

		echo '<script src="//apis.google.com/js/platform.js" async defer></script>';
	}
}
