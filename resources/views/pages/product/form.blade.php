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
                            <form action="{{url('categories/'.$id_categories.'/product/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <input type="hidden" class="id" name="id" value="{{$data->id}}">
                                <input type="hidden" class="category_id" name="category_id" value="{{$id_categories}}">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Nama</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="text" id="name" name="name" value="{{$data->name}}" required>
                                        </div> 
                                    </div> 
                                </div>
                                {{-- <div class="form-group">
                                    <div class="row">
                                        <label class="col-3 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Kategori</label>
                                        <div class="col-9 col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value=''>-</option>
                                                @foreach ($categories as $categories)
                                                    <option @if($data->category_id==$categories->id ) {{ __('selected') }} @endif  value={{$categories->id}}>{{$categories->name}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div> 
                                </div> --}}
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Gambar</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input type="file" name="image" id="image" accept="image/*">
                                            <br>
                                            @foreach ($media as $media)
                                                <img src="{{ $media->getUrl() }}" alt="" width="300px" height="auto">
                                            @endforeach
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Deskripsi</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{$data->description}}</textarea>
                                        </div> 
                                    </div> 
                                </div>
                            </form>
                        </div>              
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('categories/'.$id_categories.'/product')}}" class="btn btn-danger btn-cancel">Batal</a>
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