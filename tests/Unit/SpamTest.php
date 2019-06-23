<?php
namespace Tests\Unit;


use Tests\TestCase;
use App\Inspections\Spam;


class SpamTest extends TestCase
{

    /**
     * @test
     */
        function it_checks_for_invld_keywords(){
            $this->withoutExceptionHandling();
            $spam= new Spam;
            $this->assertFalse($spam->detect('innocent reply here'));
            $this->expectException( \Exception::class);
            $spam->detect('yahoo');

        }

       /**
        * @test
        */

       function it_checks_for_key_held(){
           $this->withoutExceptionHandling();
           $spam= new Spam;
           $this->expectException( \Exception::class);

            $spam->detect('hey aaaaaaaaaaa');

       }

}

?>