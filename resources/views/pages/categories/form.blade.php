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
                            <form action="{{url('categories/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <input type="hidden" class="id" name="id" value="{{$data->id}}">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-3 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Nama</label>
                                        <div class="col-9 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="text" id="name" name="name" value="{{$data->name}}" required>
                                        </div> 
                                    </div> 
                                </div>
                            </form>
                        </div>              
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('categories')}}" class="btn btn-danger btn-cancel">Batal</a>
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