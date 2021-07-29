@extends('app')

@section('assinatura')
<div class="container">
   <div class="row">
       <div class="col-md-6 offset-md-3 mt-5">
           <div class="card">
               <div class="card-header">
                   <h4>Assinatura do documento: </h4>
                   <h5>por: </h5>
               </div>
               <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('assinatura.upload') }}">
                        @csrf
                        <div class="col-md-12">
                            <label class="" for="">Assine aqui:</label>
                            <br/>
                            <div id="ass" ></div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="limpar" class="btn btn-danger btn-sm">Limpar</button>
                                </div>
                            </div>
                            <textarea id="assinatura" name="assinatura" style="display: none"></textarea>
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
    var assinatura = $('#ass').signature({syncField: '#assinatura', syncFormat: 'PNG'});
    $('#limpar').click(function(e) {
        e.preventDefault();
        assinatura.signature('clear');
        $("#assinatura").val('');
    });
</script>

@endsection
