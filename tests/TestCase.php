<?php

namespace Tests;

use App\Http\Controllers\JWTAuthController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp() : void 
    {
        parent::setUp();
    }
}
