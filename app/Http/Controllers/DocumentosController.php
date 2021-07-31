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
        $fileName = time().'.'.$request->documento->getClientOriginalExtension();
        $request->documento->move(public_path('upload'), $fileName);
        
        $request['status'] = 'Criado';
        $request['documento'] = $fileName;

        $documento = $this->documento->create($request->post());
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

        if($documento->assinatura != null){
            $data = [
                'nome_assinante' => $documento->assinante,
                'cpf' => $documento->cpf,
                'num_inscricao' => $documento->num_inscricao,
                'edital' => '2983-',
                'dia' => date('d'),
                'mes' => date('F'),
                'assinatura' => $documento->assinatura,
            ];
    
            $pdf = PDF::loadView('pdf', $data);
      
            return $pdf->download('documento.pdf');
        }
        else{
            return abort(403, "O documento ainda não foi assinado!");
        }
        
    }
}
