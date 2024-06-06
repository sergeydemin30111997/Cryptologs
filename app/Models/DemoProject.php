<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Intervention\Image\ImageManagerStatic as Image;

class DemoProject extends Model
{

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'demo_project';

    public static function createProject(Request $request)
    {
        if ($request->name && $request->description) {
            $demo_project = new DemoProject();
            $demo_project->name = $request->name;
            $demo_project->description = $request->description;
            if ($request->hasFile('image')) {
                $destinationPath = 'demo_project_image/';
                $file = $request->file('image');
                $file_name = Random::generate('10', '0-9a-z').'-'.$file->getClientOriginalName();
                $demo_project->image = $destinationPath.$file_name;
                $image_resize = Image::make($file->getRealPath());
                $image_resize->save(public_path($demo_project->image));

            }else {
                $destinationPath = 'demo_project_image/';
                $file_name = 'default.png';
                $demo_project->image = $destinationPath.$file_name;
            }
            if ($request->url_project) {
                $demo_project->url_project = $request->url_project;
            }
            $demo_project->save();
            return true;
        }
        return false;
    }

    public static function updateProject(Request $request, $id)
    {
        if ($request->name && $request->description) {
            $demo_project = DemoProject::find($id);
            $demo_project->name = $request->name;
            $demo_project->description = $request->description;
            if ($request->hasFile('image')) {
                $destinationPath = 'demo_project_image/';
                $file = $request->file('image');
                $file_name = Random::generate('10', '0-9a-z').'-'.$file->getClientOriginalName();
                $demo_project->image = $destinationPath.$file_name;
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(null, 150);
                $image_resize->save(public_path($demo_project->image));

            }elseif($demo_project->image == null) {
                $destinationPath = 'demo_project_image/';
                $file_name = 'default.png';
                $demo_project->image = $destinationPath.$file_name;
            }
            if ($request->url_project) {
                $demo_project->url_project = $request->url_project;
            }else {
                $demo_project->url_project = null;
            }
            $demo_project->save();
            return true;
        }
        return false;
    }
}
