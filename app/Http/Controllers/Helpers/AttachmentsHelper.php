<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait AttachmentsHelper
{

    protected $disk_directory = "";

    public function file_data($file)
    {
        return array(
            'filename' => $file->getClientOriginalName(),
            'disk_filename' => time() . '_' . $file->hashName(),
            'filesize' => $file->getClientSize(),
            'content_type' => $file->getClientMimeType(),
        );
    }

    /**
     * Gravar ficheiro na base dados
     * Gravar files no route system (Local storage drive)
     *
     * @param int $container_id
     * @param file $file
     * @param string $container_type
     * @param string $description
     *
     * @return void
     */
    public function store_attachment($container_id, $file, $container_type = null, $description = null)
    {
        if ($container_id == null) {
            $this->disk_directory = date('Y');
        } else {
            $this->disk_directory = date('Y') . '/' . $container_id;
        }
        try {

            $attachments = new Attachments();
            $attachments->container_id = $container_id;
            $attachments->container_type = $container_type;
            $attachments->content_type = $this->file_data($file)['content_type'];
            $attachments->filename = $this->file_data($file)['filename'];
            $attachments->disk_filename = $this->file_data($file)['disk_filename'];
            $attachments->filesize = $this->file_data($file)['filesize'];
            $attachments->digest = \md5($file);
            $attachments->downloads = 0;
            $attachments->author_id = Auth::user()->id;
            $attachments->created_on = now();
            $attachments->description = $description;
            $attachments->disk_directory = $this->disk_directory;
            $attachments->save(); // Save data into database

            $path = $file->storeAs('public/' . $this->disk_directory, $this->file_data($file)['disk_filename']);
            // Storage::put($this->disk_directory, $file);
        } catch (\Throwable $th) {
            return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            throw $th;
        }
    }
}
