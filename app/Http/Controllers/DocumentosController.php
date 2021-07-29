<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documento = Documento::all(['id', 'nome', 'assinante', 'status', 'documento']);
        return response()->json($documento);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileName = time().'.'.$request->documento->getClientOriginalExtension();
        $request->documento->move(public_path('upload'), $fileName);
        
        $request['status'] = 'Criado';
        $request['documento'] = $fileName;

        $documento = Documento::create($request->post());
        return response()->json([
            'message'=>'Documento criado com sucesso!!',
            'documento'=>$documento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        $fileName = time().'.'.$request->documento->getClientOriginalExtension();
        $request->documento->move(public_path('upload'), $fileName);
        
        $request['documento'] = $fileName;

        if(File::exists(public_path('upload/'.$documento->documento))){
            File::delete(public_path('upload/'.$documento->documento));
        }

        $documento->fill($request->post())->save();
        return response()->json([
            'message'=>'Documento atualizado com sucesso!!',
            'documento'=>$documento
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        if(File::exists(public_path('upload/'.$documento->documento))){
            File::delete(public_path('upload/'.$documento->documento));
        }

        $documento->delete();
        return response()->json([
            'message'=>'Documento deletado com sucesso!!'
        ]);
    }
}
