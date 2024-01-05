<x-app>
    <div class="content-wrapper">
        <section class="content py-3">
            <div class="container-fluid">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{ $errors->first() }}
                </div>    
                @endif
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{ session('success') }}
                    </div>    
                @endif
                <div class="card card-white">
                    <div class="card-header"> 
                        <h5>
                            <a class="text-secondary" href={{url('dashboard')}}><i class="fas fa-home"></i></a> \
                            <a class="text-secondary title" href="#">{{$title}}</a>
                        </h5>
                      </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <form action="{{url('user/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Nama</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="text" id="name" name="name" value="" placeholder="Masukkan Nama" required>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Email</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="email" id="email" name="email" value="" placeholder="Masukkan Email" required>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Kata Sandi</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input class="form-control" type="password" id="password" name="password" value="" placeholder="Masukkan Kata sandi" required autocomplete="off">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-3 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Konfirmasi Kata Sandi</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <input name="password_confirmation" class="form-control" type="password" placeholder="Konfirmasi kata sandi" required autocomplete="off">
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