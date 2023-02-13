<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    /**
     * Show Documents by record id
     */
    public function show($id)
    {
        $attachments = Attachments::select('attachments.id as attach_id', 'digest', 'documents.id as doc_id', 'projects.id as project_id', 'filename', 'disk_filename', 'filesize', 'documents.title', 'documents.description', 'content_type', 'name', 'identifier', 'firstname as author_firstname', 'lastname as author_lastname', 'attachments.created_on')
            ->join('documents', 'documents.id', 'container_id')
            ->join('projects', 'projects.id', 'documents.project_id')
            ->join('users', 'users.id', 'attachments.author_id')
            ->where('attachments.container_id', $id)
            ->where(function ($q) {
                $q->where('is_public', true)->orWhere('attachments.author_id', Auth::user()->id);
            })
            ->get();

        $projects = array(
            'project_id' => $attachments[0]['project_id'],
            'name' => $attachments[0]['name'],
            'identifier' => $attachments[0]['identifier'],
        );


        $data = array(
            'attachments' => $attachments,
            'projecto' => $projects,
        );

        // return $data;
        return view('attachments.show', ['data' => $data]);
    }

    /**
     * show attach file
     */
    public function showAttach(Attachments $attachment, $filename)
    {
        $attachment->where('filename', $filename)->firstOrFail();
        //dd($attachment);
        $attachment->project;
        $attachment->news;
        $attachment->download_link = $attachment->download_link();

        // return $attachment;
        return view('attachments.attach', compact('attachment'));
    }

    /**
     * Download Documents
     */

    public function download(Attachments $attachment, $filename)
    {
        try {
            $attachment->where('filename', $filename)->firstOrFail();
        } catch (\Throwable $th) {
            return back()->with('error', 'O ficheiro solicitado não foi encontrdo! Isso tudo é que nos sabemos.');
        }

        $file_path = './public/' . $attachment->disk_directory . '/' . $attachment->disk_filename;

        if (Storage::exists($file_path)) {
            $attachment->downloads = $attachment->downloads + 1;
            $attachment->update(); // Update data into database
            // Download requestfFile
            return Storage::download($file_path, $attachment->filename);
        } else {
            return back()->with('error', 'File not found in storage! Isso é tudo que nos sabemos');
        }
    }
}
