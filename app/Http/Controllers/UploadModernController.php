<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Upload;

use Auth, View, Validator,  Response, Mail, Config, Plupload;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UploadModernController extends Controller {

	public function __construct() {
		
	}

	public function create() {
		return View::make('template')->nest('content', 'upload-modern._dropzone');
	}


	/**
     * Handles the file upload
     *
     * @param FileReceiver $receiver
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws UploadMissingFileException
     *
     */
    public function store(FileReceiver $receiver)  {
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();
        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
			// save the file and return any response you need			
			$image = $save->getFile();
			$old_filename = $image->getClientOriginalName();
			$new_filename = str_replace(".".$image->getClientOriginalExtension(), "", $image->getClientOriginalName()) . "-" . time() . "." . $image->getClientOriginalExtension();
			$image->move(Config::get('ringmaster.uploads_path'), $new_filename);

			$upload = new Upload;			
			$upload->new_filename = $new_filename;
			$upload->filename = $old_filename;
			$upload->owner_id = Auth::user()->id;
			
			if ($upload->save()) {

				return Response::json(array(
					"status" 	=> "success",
					"data" 		=> $upload
				), 200);
			} else {
				return Response::json(array(
					"status" 	=> "error",
					"message" 	=> "new-modern-upload-save"
				), 400);
			}

        }
        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
		return Response::json(array(
			"status" 	=> "success",
			"data" 		=> [
				"progress" => $handler->getPercentageDone()
			]
		), 202);
    }

}
