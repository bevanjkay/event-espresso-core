<?php

if (!defined('EVENT_ESPRESSO_VERSION')) {
	exit('No direct script access allowed');
}

/**
 *
 * EE_Int_Normalization_Test
 *
 * @package			Event Espresso
 * @subpackage
 * @author				Mike Nelson
 *
 */
class EE_Int_Normalization_Test extends EE_UnitTestCase{

    /**
     * @group 10586
     */
	public function test_normalize(){
		$strategy = new EE_Int_Normalization();
		$input = new EE_Text_Input();
		$strategy->_construct_finalize( $input );
        $this->assertEquals( null, $strategy->normalize( '' ) );
        $this->assertEquals( null, $strategy->normalize( ' ' ) );
		$this->assertEquals( 10, $strategy->normalize( '10' ) );
		$this->assertEquals( 10, $strategy->normalize( '10' ) );
		$this->assertEquals( 1000, $strategy->normalize( '1,000' ) );
		$this->assertEquals( 1000, $strategy->normalize( ' 1 000 ' ) );
        $this->assertEquals( -1, $strategy->normalize( '-1' ) );

		try{
			$strategy->normalize( '10.00' );
			$this->assertTrue( FALSE );
		}catch( EE_Validation_Error $e){
			$this->assertTrue( TRUE );
		}

		try{
			$strategy->normalize( 'one hundred' );
			$this->assertTrue( FALSE );
		}catch( EE_Validation_Error $e){
			$this->assertTrue( TRUE );
		}

		try{
			$strategy->normalize( '$10' );
			$this->assertTrue( FALSE );
		}catch( EE_Validation_Error $e){
			$this->assertTrue( TRUE );
		}

		$this->assertEquals( 10, $strategy->normalize( 10 ) );
		try{
			$strategy->normalize( array() );
			$this->assertTrue( FALSE );
		}catch(EE_Validation_Error $e){
			$this->assertTrue( TRUE );
		}
	}
}

// End of file EE_Int_Normalization_Test.php
// Location: tests/testcases/core/libraries/form_sections/strategies/normalization/EE_Int_Normalization_Test.php