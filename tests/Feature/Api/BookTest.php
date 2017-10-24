<?php

namespace Tests\Feature\Api;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testAllBooksAreReturned()
    {
        $book = factory(Book::class, 10)->create();

        $response = $this->get('/api/books');

        $this->assertEquals($response->json()['data'], Book::all()->toArray());
    }
}
