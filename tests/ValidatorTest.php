<?php

use Mockery as m;

class ValidatorTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     *  @expectedException Exception
     */
    public function testValidatorThrowsExceptionOnWrongDependency()
    {
        $validator = new \App\Validators\CategoryValidator(new StdClass());
    }

    /**
     *  @expectedException Exception
     */
    public function testWithMethodThrowsExceptionIfNotArray()
    {
        $validator = new \App\Validators\CategoryValidator(m::mock('Illuminate\Validation\Factory'));
        $validator->with('this is not an array');
    }

    /**
     *  @expectedException Exception
     */
    public function testPassesMethodThrowsExceptionIfNotArray()
    {
        $validator = new \App\Validators\CategoryValidator(m::mock('Illuminate\Validation\Factory'));
        $validator->passes('this is not an array');
    }

}