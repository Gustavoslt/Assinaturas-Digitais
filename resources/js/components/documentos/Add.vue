<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Novo Documento</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="create" v-if="showForm">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" v-model="documento.nome">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Assinante</label>
                                    <input type="text" class="form-control" v-model="documento.assinante">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <input type="text" class="form-control" v-model="documento.documento">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"add-documento",
    data(){
        return {
            documento:{
                nome:"",
                assinante:"",
                documento:""
            }
        }
    },
    methods:{
        async create(){
            await this.axios.post('/api/documento',this.documento).then(response=>{
                this.$router.push({name:"documentoList"})
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>