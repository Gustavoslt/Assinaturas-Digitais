<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Documento</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="updateDocumento">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nome do Documento</label>
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
                                    <label>CPF</label>
                                    <input type="text" class="form-control" v-mask="'###.###.###-##'" v-model="documento.cpf">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nº de Inscrição</label>
                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" v-model="documento.num_inscricao">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <input type="file" id="documento" ref="documento" v-on:change="onFileChange"/>
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
    data(){
        return {
            documento:{nome:'',
            assinante:'',
            cpf:'',
            num_inscricao:'',
            documento:'',
            _method:"patch"}
        }
    },
    mounted(){
        this.showDocumento()
    },
    methods:{
        onFileChange(e){
            console.log(e.target.files[0]);
            this.documento.documento = e.target.files[0];
        },
        async showDocumento(){
            await this.axios.get(`/api/documento/${this.$route.params.id}`).then(response=>{
                const { nome, assinante, cpf, num_inscricao, documento } = response.data
                this.documento.nome = nome
                this.documento.assinante = assinante
                this.documento.cpf = cpf
                this.documento.num_inscricao = num_inscricao
                this.documento.documento = documento
            }).catch(error=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error
                })
            })
        },
        updateDocumento(e) {
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData(e.target);

            formData.append('nome', this.documento.nome);
            formData.append('assinante', this.documento.assinante);
            formData.append('cpf', this.documento.cpf);
            formData.append('num_inscricao', this.documento.num_inscricao);
            formData.append('documento', this.documento.documento);
            formData.append('_method', 'PATCH');

            axios.post(`/api/documento/${this.$route.params.id}`, formData, config).then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Documento editado com sucesso!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    this.$router.push({name:"documentoList"})
                })
            }).catch(error=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error
                })
            })
        }
    }
}
</script>