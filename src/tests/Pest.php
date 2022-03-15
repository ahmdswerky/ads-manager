<?php

use Tests\TestCase;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    TestCase::class,
    RefreshDatabase::class,
    CreatesApplication::class,
)->in('Feature', 'Unit');
