<?php
  
namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
  
class AssinaturasController extends Controller
{
    /**
     * Display a signing pad with data from Documento
     *
     * @return response()
     */
    public function index($id)
    {
        $documento = Documento::get()->where('id', $id)->first();
        $nome_documento = $documento->nome;
        $nome_assinante = $documento->assinante;
        return view('assinatura', compact('nome_documento', 'nome_assinante', 'id'));
    }
  
    /**
     * Upload file on storage
     *
     * @return response()
     */
    public function upload(Request $request, $id)
    {
        $folderPath = public_path('upload/');
        
        $image_parts = explode(";base64,", $request->signed);
              
        $image_type_aux = explode("image/", $image_parts[0]);
           
        $image_type = $image_type_aux[1];
           
        $image_base64 = base64_decode($image_parts[1]);
           
        $file = $folderPath . $id . '.'.$image_type;
        file_put_contents($file, $image_base64);
        return back()->with('success', 'A assinatura foi salva com sucesso!');
    }
}