<?php

namespace Tests\Feature\Books;

use App\Book;
use App\Publisher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\Feature\MakesRequestsFromPage;
use Tests\TestCase;

class CrudBookTest extends TestCase
{
    use RefreshDatabase, MakesRequestsFromPage;

    public function testGenericUserCannotViewBookCreationPage()
    {
        $this->getLibrarian();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertStatus(403);
    }

    public function testLibrarianCanViewBookCreationPage()
    {
        $librarian = $this->getLibrarian();

        $this->withoutExceptionHandling();
        $response = $this->actingAs($librarian)->get(route('books.create'));

        $response->assertSuccessful();
        $response->assertViewIs('books.create');
    }

    public function testGenericUserCannotAddBooks()
    {
        $this->getLibrarian();
        $user = factory(User::class)->create();
        factory(Publisher::class)->create();

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'The Hunger Games',
            'author' => 'Suzanne Collins',
            'publisher_id' => 1,
            'release_date' => '2015-09-24',
        ]);

        $response->assertStatus(403);
        $this->assertNull(Book::first());
    }

    public function testLibrarianCanAddBooks()
    {
        $librarian = $this->getLibrarian();

        factory(Publisher::class, 2)->create();

        $response = $this->actingAs($librarian)->post(route('books.store'), [
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

        $response = $this->fromPage(route('books.create'))->actingAs($librarian)->post(route('books.store'), [
            'title' => 'The Hunger Games',
            'author' => 'Suzanne Collins',
            'publisher_id' => 2,
            'release_date' => '2015-09-24',
        ]);

        $response->assertRedirect(route('books.create'));
        $response->assertSessionHasErrors('publisher_id');
        $this->assertNull(Book::first());
    }
}
