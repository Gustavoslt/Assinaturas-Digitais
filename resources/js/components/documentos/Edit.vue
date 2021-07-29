<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Documento</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
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
                                <button type="submit" class="btn btn-primary">Update</button>
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
    name:"update-documento",
    data(){
        return {
            nome:'',
            assinante:'',
            documento:'',
            _method:"patch"
        }
    },
    mounted(){
        this.showDocumento()
    },
    methods:{
        onFileChange(e){
            console.log(e.target.files[0]);
            this.documento = e.target.files[0];
        },
        async showDocumento(){
            await this.axios.get(`/api/documento/${this.$route.params.id}`).then(response=>{
                const { nome, assinante, documento } = response.data
                this.documento.nome = nome
                this.documento.assinante = assinante
                this.documento.documento = documento
            }).catch(error=>{
                console.log(error)
            })
        },
        async update(){
            await this.axios.post(`/api/documento/${this.$route.params.id}`,this.documento).then(response=>{
                this.$router.push({name:"documentoList"})
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>