<x-app>
    <div class="content-wrapper">
        <section class="content py-3">
            <div class="container-fluid">
                <div class="card card-white">
                    <div class="card-header"> 
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-12">
                                <div class="text-left">
                                    <h6>Pesanan {{$data->status}}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-12">
                                {{-- <div class="text-right"> --}}
                                    <div class="d-lg-flex flex-row-reverse bd-highlight">
                                        <div class="flex px-2">
                                            <p class="m-0"><i class="far fa-clock"></i><span class="text-uppercase"> 
                                                {{ date('j F, Y (H:i:s)', strtotime($data->created_at)) }}
                                            </span> </p class="m-0">
                                        </div>
                                        <div class="flex px-2">
                                            <p class="m-0 fs-6"><i class="far fa-user"></i><span class="text-uppercase"> {{$data->users->name}}</span> </p class="m-0">
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        </h5>
                      </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <form action="{{url('order/save')}}" enctype="multipart/form-data" method="POST" id="mainform">
                                {{ csrf_field() }}
                                <input type="hidden" class="id" name="id" value="{{$data->id}}">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Pesanan</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <div class="container-fluid overflow-auto">

                                                <table class="table">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th colspan="2" class="text-center">Data Orderan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data_detail as $key => $detail)
                                                        <tr>
                                                            <td>{{$key +1}}</td>
                                                            <td style="width: 25%">
                                                                @if($mediaItem = $detail->variant->getFirstMedia('variant-image'))
                                                                    <img src="{{ $mediaItem->getUrl() }}" alt="Variant Image"  max-width="85px" height="85px">
                                                                @else
                                                                    <p>No image available</p>
                                                                @endif
                                                            </td>                                                        
                                                            <td>
                                                                <div class="text-left">
                                                                    {{$detail->variant->product->name}} ({{$detail->variant->name}})
                                                                </div> 
                                                                <div class="text-left">
                                                                    <div class="d-flex">
                                                                        <div class="flex">
                                                                            {{$detail->qty}} x &nbsp;
                                                                        </div>
                                                                        <div class="flex">
                                                                            Rp. {{ number_format(($detail->total + $detail->discount)/$detail->qty,0,',','.') }} = &nbsp;
                                                                        </div>
                                                                        <div class="flex">
                                                                                @if($detail->variant->discount->value !== 0)
                                                                                    <p class="m-0">
                                                                                        Rp. {{ number_format($detail->total,0,',','.') }}
                                                                                            <span class="ml-2 bg-red text-white rounded" style="padding: 1.5px 2.8px">
                                                                                                -Rp. {{ number_format($detail->discount, 0, ',', '.') }}
                                                                                            </span>
                                                                                    </p>
                                                                                    <p class="m-0" style="text-decoration: line-through;">
                                                                                        Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                                                    </p>
                                                                                @else
                                                                                    <p>Rp. {{ number_format($detail->total,0,',','.') }}</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                </div> 
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Sub Total</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <p>Rp. {{ number_format($data->subtotals,0,',','.') }}</p>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Promo</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <div class="d-flex">
                                                <div class="flex pr-4">
                                                    <h6>{{$data->promo == null ? 'Tidak ada promo' :$data->promo->name}}</h6>
                                                </div>
                                                <div class="flex px-4  "> 
                                                    <h6>{{$data->promo == null ? '0' : '-'. $data->discount_promo}}</h6>
                                                </div>
                                            </div>
                                            {{-- <input class="form-control" type="text" id="promo" name="promo" value="{{$data->promo == null ? '0' :$data->promo->value}}" readonly> --}}
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Total</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <p>Rp. {{ number_format($data->total_price,0,',','.') }}</p>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-12 col-md-3 col-sm-3 col-xs-12 control-label" for="inputName">Status</label>
                                        <div class="col-12 col-md-9 col-sm-9 col-xs-12">
                                            <select class="form-control {{$data->status}}" name="status" id="status" required {{ $data->status == 'Done' ? 'disabled'  : '' }}>
                                                <option @if($data->status=='Pending' ) {{ __('selected') }} @endif value='Pending'>Pending</option>
                                                <option @if($data->status=='Process' ) {{ __('selected') }} @endif value='Process'>Process</option>
                                                <option @if($data->status=='Ready' ) {{ __('selected') }} @endif value='Ready'>Ready</option>
                                                <option @if($data->status=='Done' ) {{ __('selected') }} @endif value='Done'>Done</option>
                                                <option @if($data->status=='Cancel' ) {{ __('selected') }} @endif value='Cancel'>Cancel</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </form>
                        </div>              
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('order')}}" class="btn btn-danger btn-cancel">Batal</a>
                        <button type="submit" form="mainform" id="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
         </section>
    </div>
</x-app>
<script type="text/javascript">
$(document).ready(function(){
    // $('#table-data').DataTable({
    // });
});
</script>