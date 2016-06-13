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
        $validator = new \App\Validators\CategoryCreateValidator(new StdClass());
    }

    /**
     *  @expectedException Exception
     */
    public function testWithMethodThrowsExceptionIfNotArray()
    {
        $validator = new \App\Validators\CategoryCreateValidator(m::mock('Illuminate\Validation\Factory'));
        $validator->with('this is not an array');
    }

    /**
     *  @expectedException Exception
     */
    public function testPassesMethodThrowsExceptionIfNotArray()
    {
        $validator = new \App\Validators\CategoryCreateValidator(m::mock('Illuminate\Validation\Factory'));
        $validator->passes('this is not an array');
    }

}