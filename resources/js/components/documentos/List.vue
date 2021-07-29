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
                                    <th>Status</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody v-if="documentos.length > 0">
                                <tr v-for="(documento,key) in documentos" :key="key">
                                    <td>{{ documento.nome }}</td>
                                    <td>{{ documento.assinante }}</td>
                                    <td>{{ documento.status }}</td>
                                    <td>
                                        <router-link :to='{name:"documentoEdit",params:{id:documento.id}}' class="btn btn-success">Editar</router-link>
                                        <button type="button" class="btn btn-info">Assinar</button>
                                        <button type="button" class="btn btn-danger">Baixar</button>
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
                console.log(error)
                this.documentos = []
            })
        },
        deleteDocumento(id){
            if(confirm("Tem certeza que deseja excluir esse documento?")){
                this.axios.delete(`/api/documento/${id}`).then(response=>{
                    this.getDocumentos()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
}
</script>