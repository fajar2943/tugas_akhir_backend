<x-app>
    <div class="content-wrapper">
        <section class="content py-3">
            <div class="container-fluid">
                <div class="card card-white">
                    <div class="card-header"> 
                        <h5>
                            <a class="text-secondary" href={{url('dashboard')}}><i class="fas fa-home"></i></a> \
                            <a class="text-secondary title" href="#">{{$title}}</a>
                        </h5>
                      </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <form action="{{url('discount/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <input type="hidden" class="id" name="id" value="{{$data->id}}">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Nama</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="text" id="name" name="name" value="{{$data->name}}" required>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Nominal</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <div class="input-group mb-3">
                                                <input type="text" id="value" name="value" min="0" class="form-control rupiah"  value="{{$data->value}}"  required>
                                                <div class="input-group-append">
                                                    <select class="form-control" name="type" id="type" required>
                                                        <option selected="" value="">-</option>
                                                        <option @if($data->type== 'Percent' ) {{ __('selected') }} @endif value="Percent">%</option>
                                                        <option @if($data->type== 'Nominal' ) {{ __('selected') }} @endif value="Nominal">Rupiah</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                            </form>
                        </div>              
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('discount')}}" class="btn btn-danger btn-cancel">Batal</a>
                        <button type="submit" form="mainform" id="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
         </section>
    </div>
</x-app>
<script type="text/javascript">
$(document).ready(function(){
    $('#table-data').DataTable({
    });
});
</script>