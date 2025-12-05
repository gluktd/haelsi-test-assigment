<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spectator\Spectator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)
    ->beforeEach(function () {
        Spectator::using('openapi.json');
        $this->seed(DatabaseSeeder::class);
    })->in('Unit', 'Feature');
