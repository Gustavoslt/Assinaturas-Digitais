@extends('app')

@section('assinatura')
<div class="container">
   <div class="row">
       <div class="col-md-6 offset-md-3 mt-5">
           <div class="card">
               <div class="card-header">
                   <h4>Documento: {{$nome_documento}}</h4>
                   <h5>Assinado por: {{$nome_assinante}}</h5>
               </div>
               <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('assinatura.upload', $id) }}">
                        @csrf
                        <div class="col-md-12">
                            <label class="" for="">Assine aqui:</label>
                            <br/>
                            <div id="sig" ></div>
                            <br/>
                            <button id="limpar" class="btn btn-danger btn-sm">Limpar</button>
                            <textarea id="assinatura" name="signed" style="display: none"></textarea>
                        </div>
                        <br/>
                        <button class="btn btn-success">Salvar</button>
                    </form>
               </div>
           </div>
       </div>
   </div>
</div>

<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#assinatura', syncFormat: 'PNG'});
    $('#limpar').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#assinatura").val('');
    });
</script>
@endsection
