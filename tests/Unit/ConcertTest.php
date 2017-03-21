<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\BrowserKitTestCase;

class ConcertTest extends BrowserKitTestCase
{
    // for now if using Model->make there is no need in migrations
    // use DatabaseMigrations;

    /** @test */
    public function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make([ // use make instead off create for using in memory storage and prevent storing in database for speed
            'date' => Carbon::parse('2016-12-01 8:00pm'),
        ]);

        $this->assertEquals('December 1, 2016', $concert->formatted_date);
    }

    /** @test */
    public function can_get_formatted_start_date()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2016-12-01 17:00:00'),
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_time);
    }

    /** @test */
    public function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }
}