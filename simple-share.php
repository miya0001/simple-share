<?php
/*
Plugin Name: Simple Share
Version: 0.1.0
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
		add_filter( 'the_content', array( $this, 'the_content' ), 9999 );
		add_action( 'wp_head', array( $this, 'wp_head' ), 9999 );
	}


	public function wp_head()
	{
		?>
		<!-- simple-share -->
		<style type="text/css">
			.simple-share
			{
				overflow: auto;
			}
			.simple-share .simple-share-button
			{
				float: left;
				margin-right: 10px;
			}
			@media screen and (max-width: 480px) {
				.simple-share
				{
					display: none;
				}
			}
		</style>
		<!-- end simple-share -->
		<?php
	}


	public function the_content( $contents )
	{
		if ( ! is_singular() ) {
			return $contents;
		}

		$buttons = $this->get_share_buttons();
		$share = '<div class="simple-share">';
		foreach ( $buttons as $key => $btn ) {
			$share .= '<div class="simple-share-button simple-share-' . esc_attr( $key ) . '">';
			$share .= sprintf( $btn, esc_attr( get_permalink() ), esc_attr( get_the_title() ) );
			$share .= '</div>';
		}
		$share .= '</div>';

		return $share . $contents;
	}


	public function get_share_buttons()
	{
		$share_buttons = array(
			'twitter' => '<a class="twitter-share-button" href="https://twitter.com/share" data-lang="ja" data-count="vertical">Tweet</a>
			<script type="text/javascript">// <![CDATA[
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
				// ]]></script>',
			'facebook' => '<div class="fb-like" data-href="%1$s" data-send="false" data-layout="box_count" data-show-faces="false"></div>',
			'google' => '<div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
			<script type="text/javascript">
			(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \'https://apis.google.com/js/plusone.js\';
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
				})();
				</script>',
		);

		if ( 'ja' === get_locale() ) {
			$share_buttons['hatena'] = '<a href="http://b.hatena.ne.jp/entry/%1$s" class="hatena-bookmark-button" data-hatena-bookmark-title="%2$s" data-hatena-bookmark-layout="vertical-balloon" data-hatena-bookmark-lang="en"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>';
		}

		return apply_filters( 'simple_share_get_share_buttons', $share_buttons );
	}

}
