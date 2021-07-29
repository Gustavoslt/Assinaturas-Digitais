<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Novo Documento</h4>
                </div>
                <div class="card-body">
                    <form @submit="formSubmit" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" v-model="nome">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Assinante</label>
                                    <input type="text" class="form-control" v-model="assinante">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <input type="file" id="documento" ref="documento" v-on:change="onFileChange"/>
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
    data() {
        return {
            nome: '',
            assinante: '',
            documento: ''
        };
    },
    methods: {
        onFileChange(e){
            console.log(e.target.files[0]);
            this.documento = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('nome', this.nome);
            formData.append('assinante', this.assinante);
            formData.append('documento', this.documento);

            axios.post('/api/documento', formData, config)
            .then(function (response) {
                this.$router.push({name:"documentoList"})
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>