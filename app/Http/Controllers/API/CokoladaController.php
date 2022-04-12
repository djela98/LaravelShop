<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cokolada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;



class CokoladaController extends Controller
{
    public function sacuvajCokoladu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv' => 'required',
            'opis' => 'required',
            'cena' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()]
            );
        } else {
            $cokolada = new Cokolada;
            $cokolada->naziv = $request->input('naziv');
            $cokolada->opis = $request->input('opis');
            $cokolada->cena = $request->input('cena');

            if ($request->hasFile('slika')) {
                $file = $request->file('slika');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/cokolada/', $filename);
                $cokolada->slika = 'uploads/cokolada/' . $filename;
            }

            $cokolada->save();
            return response()->json(
                ['status' => 200]
            );
        }
    }


    public function prikaziCokolade()
    {
        $cokolade = Cokolada::all();
        return response()->json([
            'status' => 200,
            'cokolade' => $cokolade
        ]);
    }

    public function izmenaCokolade($cokoladaID)
    {
        $cokolada = Cokolada::find($cokoladaID);

        if ($cokolada) {
            return response()->json([
                'status' => 200,
                'cokolada' => $cokolada
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Greska'
            ]);
        }
    }

    public function sacuvajIzmene(Request $request, $cokoladaID)
    {
        $validator = Validator::make($request->all(), [
            'naziv' => 'required',
            'opis' => 'required',
            'cena' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()]
            );
        } else {
            $cokolada = Cokolada::find($cokoladaID);

            if ($cokolada) {
                $cokolada->naziv = $request->input('naziv');
                $cokolada->opis = $request->input('opis');
                $cokolada->cena = $request->input('cena');

                if ($request->hasFile('slika')) {
                    $path = $cokolada->slika;

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    $file = $request->file('slika');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/cokolada/', $filename);
                    $cokolada->slika = 'uploads/cokolada/' . $filename;
                }

                $cokolada->update();
                return response()->json(
                    ['status' => 200]
                );
            } else {
                return response()->json(
                    [
                        'status' => 404,
                        'message' => 'Greska'
                    ]
                );
            }
        }
    }
}
