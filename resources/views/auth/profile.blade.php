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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-3 col-sm-12">
                                <div class="text-center">
                                    <div class="pt-5 pb-3">
                                        <i class="fas fa-user text-secondary" style="font-size: 120px"></i>
                                    </div>
                                </div>
                                <div class="form-group text-center text-lg-left">
                                    <h4 class="text-secondary text-uppercase"><b>{{Auth::user()->name}}</b></h4>
                                    <div class="row align-items-center text-secondary">
                                        <div class="col-1 col-md-1 col-sm-1 col-xs-1">
                                          <i class="fas fa-briefcase"></i>
                                        </div>
                                        <div class="col-10 col-md-10 col-sm-10 col-xs-10">
                                            <h6 class="m-0 pl-2 text-uppercase">{{Auth::user()->role}}</h6>
                                        </div>
                                    </div>
                                    <div class="row align-items-center text-secondary">
                                        <div class="col-1 col-md-1 col-sm-1 col-xs-1">
                                          <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="col-10 col-md-10 col-sm-10 col-xs-10">
                                            <h6 class="m-0 pl-2">{{Auth::user()->email}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 col-md-9 col-sm-12">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" aria-selected="true">Ganti Kata Sandi</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-panel">
                                                <form action="{{url('changepassword')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <p class="col-md-3 col-sm-3 col-xs-12 control-label">Kata sandi lama</p>
                                                            <div class="col-md-9 col-sm-9 col-x12">
                                                                <input name="old_password" class="form-control" type="password" placeholder="Kata sandi lama">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <p class="col-md-3 col-sm-3 col-xs-12 control-label">Kata sandi baru</p>
                                                            <div class="col-md-9 col-sm-9 col-x12">
                                                                <input name="new_password" class="form-control" type="password" placeholder="Kata sandi baru">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <p class="col-md-3 col-sm-3 col-xs-12 control-label">Konfirmasi sandi baru</p>
                                                            <div class="col-md-9 col-sm-9 col-x12">
                                                                <input name="new_password_confirmation" class="form-control" type="password" placeholder="Konfirmasi kata sandi baru">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="text-right">
                                                    <button type="submit" form="mainform" id="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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