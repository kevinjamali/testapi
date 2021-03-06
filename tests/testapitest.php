<?php
use PHPUnit\Framework\TestCase;
class testapitest extends TestCase {
	public function testapitestFinder() {
		require '_functions.php';
		$testArray = array("from"=>"2020-02-16 00:00:00","to"=>"2020-03-11 00:00:00","type"=>"none","convertparam"=>"none","days"=>"25","weekdays"=>"18","completeweeks"=>"3");
		$functionArray = finder("2020-02-16","2020-03-11",null,null);
		
		$this->assertTrue(arrays_are_similar($testArray,$functionArray ));
		
	}
	
	public function testapitestFinderDaysMenuets() {
		
		$testArray2 = array("from"=>"2020-02-16 00:00:00","to"=>"2020-03-11 00:00:00","type"=>"minutes","convertparam"=>"days","days"=>"36000","weekdays"=>"18","completeweeks"=>"3");
		$functionArray2 = finder("2020-02-16","2020-03-11","minutes","days");
		$this->assertTrue(arrays_are_similar($testArray2,$functionArray2 ));
		
	}
	
	public function testConvetTo() {
		
		$this->assertEquals(86400, convertto(1,"seconds"));
		$this->assertEquals(1440, convertto(1,"minutes"));
		$this->assertEquals(24, convertto(1,"hours"));
		$this->assertEqualsWithDelta(0.002739, convertto(1,"years"), 0.0001);
		
		;
	}
}