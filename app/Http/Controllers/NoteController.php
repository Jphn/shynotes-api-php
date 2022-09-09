<?php

namespace App\Http\Controllers;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private Note $note)
    {
    }

    public function postNote(Request $req)
    {
        $this->validate($req, [
            'name' => 'required|string',
            'content' => 'nullable|string'
        ]);

        $data = $req->only(['name', 'content']);

        $this->note->create($data);

        return response()->json([], 201);
    }

    public function deleteNote(string $name)
    {
        $this->note->where('name', $name)->delete();

        return response()->json([], 204);
    }

    public function getNoteByName(string $name)
    {
        $note = $this->note->where('name', $name)->get();

        return response()->json($note->toArray(), 200);
    }

    public function putNoteNewValues(Request $req, string $name)
    {
        $data = $req->only(['name', 'content']);

        $note = $this->note->where('name', $name)->update($data);

        return response()->json([], 202);
    }
}
