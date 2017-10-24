<?php

namespace Tests\Feature\Books;

use App\Book;
use App\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\MakesRequestsFromPage;
use Tests\TestCase;

class CrudBookTest extends TestCase
{
    use RefreshDatabase, MakesRequestsFromPage;

    public function testLibrarianCanAddBooks()
    {
        $librarian = $this->getLibrarian();

        factory(Publisher::class, 2)->create();

        $this->withoutExceptionHandling();
        $response = $this->actingAs($librarian)->post('/books', [
            'title' => 'The Hunger Games',
            'author' => 'Suzanne Collins',
            'publisher_id' => 2,
            'release_date' => '2015-09-24',
        ]);

        $response->assertRedirect(route('books.index'));
        $book = Book::first();
        $this->assertNotNull($book);
        $this->assertEquals('The Hunger Games', $book->title);
        $this->assertEquals('Suzanne Collins', $book->author);
        $this->assertEquals(2, $book->publisher_id);
        $this->assertEquals('2015-09-24', $book->release_date);
    }

    public function testLibrarianCannotAddBooksWithNonexistentPublisher()
    {
        $librarian = $this->getLibrarian();

        $response = $this->fromPage(route('books.create'))->actingAs($librarian)->post('/books', [
            'title' => 'The Hunger Games',
            'author' => 'Suzanne Collins',
            'publisher_id' => 2,
            'release_date' => '2015-09-24',
        ]);

        $response->assertRedirect(route('books.createx'));
        $response->assertSessionHasErrors('publisher_id');
        $this->assertNull(Book::first());
    }
}
