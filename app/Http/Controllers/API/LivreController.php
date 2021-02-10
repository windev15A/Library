<?php

namespace App\Http\Controllers\API;

use App\Livre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;


class LivreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $livres = Livre::paginate(6);
        foreach ($livres as $livre) {
            $catId = $livre->categories->toArray();
        }
        return Response()->json(['livres' => $livres]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'numISBN' => 'required|numeric',
            'titre' => 'required|string|max:70',
            'description' => 'required|string|max:255',
            'langueLivre' => 'required|string|max:30|min:2',
            'annee' => 'required|numeric',
            'nbPage' => 'required|numeric',
            'dateAchat' => 'required|date',
            'photo' => 'required'
        ]);
        $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

        Image::make($request->photo)->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('img/') . $name);


        // \Image::make($request->photo)->save(public_path('img/').$name);
        $livre = new Livre([
            'numISBN' => $request->get('numISBN'),
            'titre' => $request->get('titre'),
            'description' => $request->get('description'),
            'langueLivre' => $request->get('langueLivre'),
            'annee' => $request->get('annee'),
            'nbPage' => $request->get('nbPage'),
            'dateAchat' => $request->get('dateAchat'),
            'auteur_id' => $request->get('auteur_id'),
            'photo' => $name
        ]);
        $livre->save();

        $categories = $request->get('categories');
        foreach ($categories as $cat) {
            $tablecat[] = $cat['id'];
        }

        $livre->categories()->attach($tablecat);

        return Response()->json(['etat' => true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'numISBN' => 'required|numeric',
            'titre' => 'required|string|max:70',
            'description' => 'required|string|max:255',
            'langueLivre' => 'required|string|max:30|min:2',
            'annee' => 'required|numeric',
            'nbPage' => 'required|numeric',
            'dateAchat' => 'required|date',
        ]);
        $livre = Livre::findOrFail($id);

        $currentPhoto = $livre->photo;
        if ($request->photo !== $currentPhoto) {
            $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            Image::make($request->photo)->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('img/') . $name);
            //  \Image::make($request->photo)->save(public_path('img/').$name);

            $request->merge(['photo' => $name]);
            $livrePhoto = public_path('img/') . $currentPhoto;

            if (File::exists($livrePhoto)) {
                File::delete($livrePhoto);
            }
        }
        $livre->update($request->all());

        $categories = $request->get('categories');
        foreach ($categories as $cat) {
            $tablecat[] = $cat['id'];
        }

        $livre->categories()->sync($tablecat);

        return Response()->json(['etat' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Livre $livre
     * @return void
     * @throws Exception
     */
    public function destroy(Livre $livre)
    {
        $livre->categories()->sync([]);
        $livrePhoto = public_path('img/') . $livre->photo;
        if (file_exists($livrePhoto)) {
            File::delete($livrePhoto);
        }
        $livre->delete();
    }
}
