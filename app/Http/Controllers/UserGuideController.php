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
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
                'action'        => 'User id' . auth()->user()->id .' uploading file for User Guide'
            ]);

            $file = $request->all();
            if ($file['file']->getClientOriginalExtension() != 'pdf') {
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
                    'action'        => 'User id' . auth()->user()->id .' uploading file error for User Guide - The files must be a file of type: pdf.'
                ]);

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

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
                'action'        => 'User id' . auth()->user()->id .' done uploading file for User Guide'
            ]);

            return response()->json($userGruop);

        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
                'action'        => 'User id' . auth()->user()->id .' error uploading file for User Guide'
            ]);
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

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
            'action'        => 'preparing to download file ' . $file->filename . ' - User Guide'
        ]);

        $contentType = 'Content-Type: application/' . explode('.', $file->path)[1];
        $headers = [
            $contentType,
        ];
        $download = storage_path($file->path);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-guide')->value('id'),
            'action'        => 'preparation done downloading file ' . $file->filename . ' - User Guide'
        ]);
        return Response::download($download, $file->filename, $headers);
    }
}