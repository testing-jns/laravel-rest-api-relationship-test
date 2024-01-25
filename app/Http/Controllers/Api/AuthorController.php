<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorCollection;
use Illuminate\Database\Eloquent\Collection;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 6;
        $path = $request->getUriForPath('') . $request->getPathInfo();

        $authors = Author::with('posts')->get();

        $authorsWithPostResource = Author::withPostResource($authors);

        $authors = Author::paginate($authorsWithPostResource, $perPage)->withPath($path);

        return new AuthorCollection($authors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
