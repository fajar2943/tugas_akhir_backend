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
                            <form action="{{url('categories/'.$id_categories.'/product/'.$id_product.'/variant/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <input type="hidden" class="id" name="id" value="{{$data->id}}">
                                <input type="hidden" class="category_id" name="category_id" value="{{$id_categories}}">
                                <input type="hidden" class="product_id" name="product_id" value="{{$id_product}}">
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
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Diskon</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control" name="discount_id" id="discount_id" required>
                                                <option value=''>-</option>
                                                @foreach ($discount as $discount)
                                                    <option @if($data->discount_id==$discount->id ) {{ __('selected') }} @endif  value={{$discount->id}}>{{$discount->name . ' (' . $discount->value . ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Harga</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control rupiah" type="text" id="price" name="price" value="{{$data->price}}" required>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Stok</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="number" id="stock" name="stock" min="0" value="{{$data->stock}}" required>
                                        </div> 
                                    </div> 
                                </div>
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
                            </form>
                        </div>              
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('categories/'.$id_categories.'/product/'.$id_product.'/variant')}}" class="btn btn-danger btn-cancel">Batal</a>
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