=== Simple Share ===
Contributors: miyauchi, hissy
Tags: share, social, twitter, facebook, hatena, google
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 0.8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

You can place share buttons just activating this plugin.

== Description ==

You can place share buttons just activating this plugin.

* There is no admin panel.
* You can place just four buttons twitter, facebook, google, hatena(ja only).
* They will be hidden at mobile screen (under 480px).

= Filter hook =

* simple_share_the_content - Filter the content.
* simple_share_get_share_buttons - Filter the share buttons.
* simple_share_mobile_footer - Filter the footer buttons on mobile.
* simple_share_style - Filter the css.

= Placing share buttons in the footer. =

`
add_filter( 'simple_share_the_content', function( $content, $share, $orig ){
    return $share. $orig . $share;
}, 10, 3 );
`

= Other Notes =

If you would have conflicts with other plugins you can stop JavaScripts in the footer like below.

* `remove_action( 'simple_share_footer', array( $simple_share, 'facebook_script' ) );` - Stop facebook scripts.
* `remove_action( 'simple_share_footer', array( $simple_share, 'google_script' ) );` - Stop Google scripts.

= Contribution =

* [https://github.com/miya0001/simple-share](https://github.com/miya0001/simple-share)

== Installation ==

1. Upload `simple-share.zip` from the admin panel.
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Share buttons for PC.
2. Share buttons for Mobile.

== Changelog ==

= 0.8.0 =

* Fix always fire scripts in the footer.
* https://github.com/miya0001/simple-share/compare/0.7.0...0.8.0

= 0.7.0 =

* Add some filters.
* https://github.com/miya0001/simple-share/compare/0.6.0...0.7.0

= 0.6.0 =

* Update facebook javascript sdk.
* Fix conflict with other plugins.

= 0.4.0 =

* Fixed typo.
* Add target arg to facebook link.

= 0.3.0 =

* Add mobile support.

= 0.2.0 =

* Fix CSS

= 0.1 =
* First release.
