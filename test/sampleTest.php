<?php
require_once "src/Sample.php";


use PHPUnit\Framework\TestCase;
use app\Sample;

class ArticleTest extends TestCase{

    protected $sample;
    protected function SetUp() :void{
        $this->sample = new Sample;
        
    }

    public function testHello()
    {
        $sample = new Sample();
        
        $result = $sample->hello();
        
        $this->assertEquals("Hello", $result);
    }
}


