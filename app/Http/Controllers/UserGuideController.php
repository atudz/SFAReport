<?php
namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserGuideController extends ControllerCore
{
    /**
     * This function will handle the file upload or user guide.
     * @param $userType
     * @param Request $request
     * @return mixed
     */
    public function userGuideFileUpload($userType, Request $request)
    {
        try {
            $file = $request->all();
            if ($file['file']->getClientOriginalExtension() != 'pdf') {
                return response()->json('The files must be a file of type: pdf.', 422);
            }

            $directory = 'app' . DIRECTORY_SEPARATOR . 'user-guide-files';
            mt_srand(time()); //seed the generator with the current timestamp
            $basename = md5(mt_rand());
            $filename = $basename . snake_case($file['file']->getClientOriginalName());

            $file['file']->move(storage_path($directory), $filename);
            $userGuideFile = ModelFactory::getInstance('UserGroup');
            $userGuideFile = $userGuideFile->whereName($userType)->with('file')->first();
            if ($userGuideFile->file) {
                \File::Delete(storage_path($userGuideFile->file->path));
                $userGuideFile->file()->delete();
            }
            $userGuideFile->file()->create([
                'path'     => $directory . DIRECTORY_SEPARATOR . $filename,
                'filename' => $file['file']->getClientOriginalName()
            ]);

            $userGruop = $userGuideFile->with('file')->where('name', '!=', 'Supper Admin')->get();

            return response()->json($userGruop);

        } catch (Exception $e) {
            return response()->json('Error in uploading file.', 500);
        }

    }

    /**
     * This function will handle for file download.
     * @param $id
     * @return mixed
     */
    public function download($id)
    {
        $file = ModelFactory::getInstance('File');
        $file = $file->find($id);
        $contentType = 'Content-Type: application/' . explode('.', $file->path)[1];
        $headers = [
            $contentType,
        ];
        $download = storage_path($file->path);

        return Response::download($download, $file->filename, $headers);
    }
}