<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"documentoAdd"}' class="btn btn-primary">Novo Documento</router-link>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Documentos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Assinante</th>
                                    <th>CPF</th>
                                    <th>Nº Inscrição</th>
                                    <th>Status</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody v-if="documentos.length > 0">
                                <tr v-for="(documento,key) in documentos" :key="key">
                                    <td>{{ documento.nome }}</td>
                                    <td>{{ documento.assinante }}</td>
                                    <td>{{ documento.cpf }}</td>
                                    <td>{{ documento.num_inscricao }}</td>
                                    <td>{{ documento.status }}</td>
                                    <td>
                                        <router-link :to='{name:"documentoEdit",params:{id:documento.id}}' class="btn btn-warning">Editar</router-link>
                                        <button type="button" @click="signDocumento(documento.id)" class="btn btn-success">Assinar</button>
                                        <button type="button" @click="downloadDocumento(documento.id)" class="btn btn-info">Baixar</button>
                                        <button type="button" @click="deleteDocumento(documento.id)" class="btn btn-danger">Excluir</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">Nenhum documento encontrado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"documentos",
    data(){
        return {
            documentos:[]
        }
    },
    mounted(){
        this.getDocumentos()
    },
    methods:{
        async getDocumentos(){
            await this.axios.get('/api/documento').then(response=>{
                this.documentos = response.data
            }).catch(error=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.response.data.message
                })
                this.documentos = []
            })
        },
        deleteDocumento(id){
            Swal.fire({
                title: 'Tem certeza que deseja excluir?',
                text: "Essa ação é irreversível!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.axios.delete(`/api/documento/${id}`).then(response=>{
                        Swal.fire(
                            'Excluido!',
                            'O documento foi excluido com sucesso!',
                            'success'
                        )
                        this.getDocumentos()
                    }).catch(error=>{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.response.data.message
                        })
                    })
                }
            })
        },
        signDocumento(id){
            window.location.href = '/assinatura/' + id;
        },
        downloadDocumento(id){
            window.location.href = '/gerar-pdf/' + id;
        }
    }
}
</script>