<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFileRequest;
use App\Http\Requests\UpdateFileRequest;

use Carbon\Carbon;

use App\File;

use File as FileManager;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();

        return response()->json(['data' => $files],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileRequest $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');

        $path = $this->storeFile($request);

        $instance = File::create(
            [
                'title' => $title,
                'description' => $description,
                'path' => $path
            ]);

        return response()->json(['data' => "The file {$instance->name} was created with id {$instance->id}"],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);

        if($file)
        {
            return response()->json(['data' => $file], 200);
        }

        return response()->json(['message' => 'Does not exists a file with that id'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, $id)
    {
        $file = File::find($id);

        if($file)
        {
            $file->title = $request->get('title');
            $file->description = $request->get('description');

            if($request->hasFile('file'))
            {
                FileManager::delete(public_path().$file->path);

                $path = $this->storeFile($request);
                $file->path = $path;
            }

            $file->save();

            return response()->json(['data' => "The file {$file->id} was updated"],200);
        }

        return response()->json(['message' => 'Does not exists a file with that id'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);

        if($file)
        {
            FileManager::delete(public_path().$file->path);

            $file->delete();

            return response()->json(['data' => "The file with id {$file->id} was removed"],200);
        }

        return response()->json(['message' => 'Does not exists a file with that id'], 404);
    }

    function storeFile($request)
    {
        $file = $request->file('file');

        $path = '/files/';
        $name = sha1(Carbon::now()).'.'.$file->guessExtension();

        $file->move(public_path().$path, $name);

        return $path.$name;
    }
}
