<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlyerControllerTest extends TestCase
{

    public function it_show_the_form_to_create_a_new_flyer()
    {
        $this->visit('flyer/create');

    }
}
