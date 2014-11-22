<?php

class Simple_Share_Test extends WP_UnitTestCase {

	/**
	 * @test
	 */
	function simple_share()
	{
		$simple_share = new Simple_Share();

		// test on the english version
		$this->assertEquals( 3, count( $simple_share->get_share_buttons() ) );


		// test on the ja version
		add_filter( 'locale', function(){
			return 'ja';
		} );

		$this->assertEquals( 4, count( $simple_share->get_share_buttons() ) );
	}
}
