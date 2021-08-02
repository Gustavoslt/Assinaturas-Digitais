<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DocumentosController extends Controller
{
    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documento = $this->documento->all();

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
        if($request->documento != null){
            $fileName = time().'.'.$request->documento->getClientOriginalExtension();
            $request->documento->move(public_path('upload'), $fileName);

            $request['documento'] = $fileName;
        }
        $request['status'] = 'Criado';

        $documento = $this->documento->create($request->post());

        if($documento){
            return response()->json([
                'message'=>'Documento criado com sucesso!!',
                'documento'=>$documento
            ]);
        }
        else {
            return response()->json([
                'error'=>'Ocorreu um erro ao criar o documento.',
            ]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        return response()->json($documento);
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
        $documento->update($request->all());

        if($documento){
            return response()->json([
                'message'=>'Documento atualizado com sucesso!!',
                'documento'=>$documento
            ]);
        }
        else {
            return response()->json([
                'error'=>'Ocorreu um erro ao atualizar o documento.',
            ]);
        }
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
        if(File::exists(public_path('upload/'.$documento->assinatura))){
            File::delete(public_path('upload/'.$documento->assinatura));
        }

        if($documento->delete()){
            return response()->json([
                'message'=>'Documento excluir com sucesso!!'
            ]);
        }
        else {
            return response()->json([
                'error'=>'Ocorreu um erro ao excluir o documento'
            ]);
        }
        
    }

    /**
     * Download file from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
		$anexo = $this->documento->findOrFail($id);
		$file_path = 'upload/'.$anexo->documento;

        $arquivo = public_path($file_path);
        
        return Response::download($arquivo);
	}

    /**
     * Download file from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function geraPDF($id)
    {
        $documento = $this->documento->findOrFail($id);
        $assinatura = null;

        if($documento->assinatura != null){
            $assinatura =$documento->assinatura;   
        }

        $data = [
            'nome_assinante' => $documento->assinante,
            'cpf' => $documento->cpf,
            'num_inscricao' => $documento->num_inscricao,
            'edital' => '2983-',
            'dia' => date('d'),
            'mes' => date('F'),
            'assinatura' => $assinatura,
        ];

        $pdf = PDF::loadView('pdf', $data);
  
        return $pdf->download('documento.pdf');
    }
}
