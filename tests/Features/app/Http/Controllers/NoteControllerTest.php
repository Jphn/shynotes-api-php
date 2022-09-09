<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Note;

class ExampleTest extends TestCase
{
	use DatabaseMigrations;

	public function testUserCanCreateANote()
	{
		// PREPARE
		$payload = [
			'name' => 'note-name',
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent feugiat diam malesuada nulla euismod porttitor molestie in lacus.'
		];

		// ACT
		$response = $this->post(route('note.create'), $payload);

		// ASSERT
		$response->seeStatusCode(201);
		$this->seeInDatabase('notes', $payload);
	}

	public function testUserShouldReceive422WhenTryingToCreateANoteWithEmptyValues()
	{
		// PREPARE
		$payload = [];

		// ACT
		$response = $this->post(route('note.create'), $payload);

		// ASSERT
		$response->seeStatusCode(422);
	}

	public function testUserCanDeleteANote()
	{
		// PREPARE
		$note = Note::factory()->create();

		// ACT
		$response = $this->delete(route('note.delete', ['name' => $note->name]));

		// ASSERT
		$response->seeStatusCode(204);
		$this->notSeeInDatabase('notes', $note->toArray());
	}

	public function testUserCanGetANote()
	{
		// PREPARE
		$note = Note::factory()->create();

		// ACT
		$response = $this->get(route('note.read.one', ['name' => $note->name]));

		// ASSERT
		$response->seeStatusCode(200);
		$response->seeJsonContains($note->toArray());
	}

	public function testUserCanEditANote()
	{
		// PREPARE
		$note = Note::factory()->create();
		$payload = [
			'name' => 'new-name',
			'content' => 'new note content'
		];

		// ACT
		$response = $this->put(route('note.update', ['name' => $note->name]), $payload);

		// ASSERT
		$response->seeStatusCode(202);
		$this->seeInDatabase('notes', $payload);
	}
}