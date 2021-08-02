<?php

namespace Tests\Feature;

use App\Models\Documento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste os fillables da tabela Documentos.
     *
     * @return void
     */
    public function test_fillables_documentos()
    {
        $documento = new Documento;

        $expected = [
            'nome',
            'assinante',
            'cpf',
            'num_inscricao',
            'assinatura',
            'status',
            'documento'
        ];

        $arrayCompared = array_diff($expected, $documento->getFillable());
        
        $this->assertEquals(0, count($arrayCompared));
    }

    /**
     * Teste que insere um documento no banco.
     *
     * @return void
     */
    public function test_insercao_de_documento()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/documento/', [
            'nome' => 'Documento Teste',
            'assinante' => 'Maria da Silva',
            'cpf' => '111.111.111-11',
            'num_inscricao' => 1234,
            'status' => 'Criado'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Teste que deleta um documento do banco.
     *
     * @return void
     */
    public function test_deletar_um_documento()
    {
        $this->withoutExceptionHandling();
        factory(Documento::class, 3)->create();
        $id_to_be_deleted = random_int(1, 5);
        $this->delete("/api/documento/$id_to_be_deleted");
        $this->assertDatabaseMissing('documentos', ['id' => $id_to_be_deleted]);
    }

    /**
     * Teste que edita um documento do banco.
     *
     * @return void
     */
    public function test_editar_um_documento(){
        $this->withoutExceptionHandling();

        $task_id = Documento::create([
            'nome' => 'Documento Teste',
            'assinante' => 'Maria da Silva',
            'cpf' => '111.111.111-11',
            'num_inscricao' => 1234,
            'status' => 'Criado'
        ])->id;

        $response = $this->patch("/api/documento/$task_id/");
        $response->assertJson([
            'message' => 'Documento atualizado com sucesso!!'
        ], true);
        
        $response->assertStatus(200);
      }
}