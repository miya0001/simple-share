<?php

class Simple_Share_Test extends WP_UnitTestCase {

	/**
	 * @test
	 */
	public function simple_share()
	{
		$simple_share = new Simple_Share();

		// test on the english version
		$this->assertEquals( 3, count( $simple_share->get_share_buttons() ) );

		$this->expectOutputString( '' ); // output nothing
		$simple_share->hatena_script();
	}

	/**
	* Change locale to ja
	*
	* @test
	*/
	public function test_in_japanese()
	{
		$simple_share = new Simple_Share();

		// test on the ja version
		add_filter( 'locale', function(){
			return 'ja';
		} );

		$this->assertEquals( 4, count( $simple_share->get_share_buttons() ) );

		$this->expectOutputRegex( '#//b.st-hatena.com/js/bookmark_button.js#' );
		$simple_share->hatena_script();
	}

	/**
	 * wp_style_is( 'simple_share' ) should be true.
	 *
	 * @test
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function wp_enqueue_scripts()
	{
		do_action( 'wp_enqueue_scripts' );
		$this->assertTrue( wp_style_is( 'simple_share' ) );
	}

	/**
	 * wp_style_is( 'simple_share' ) should be false when simple_share_style filter would return false.
	 *
	 * @test
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function filter_simple_share_style()
	{
		add_filter( 'simple_share_style', "__return_false" );
		do_action( 'wp_enqueue_scripts' );
		$this->assertFalse( wp_style_is( 'simple_share' ) );
	}
}
