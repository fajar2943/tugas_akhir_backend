<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyPackaging</title>
  <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/fontawesome-free/css/all.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }} >
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/jqvmap/jqvmap.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/dist/css/adminlte.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/daterangepicker/daterangepicker.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}>
  <link rel="stylesheet" href={{asset("AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}>
  {{-- <link rel="stylesheet" href={{asset("AdminLTE/plugins/summernote/summernote-bs4.min.css")}}> --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    {{-- top navigation --}}
   <x-navigation/>
   {{-- sidebar --}}
    <x-sidebar/>
        {{-- content --}}
        {{$slot}}
    {{-- footer --}}
    <x-footer/>
  </div>
  <script src={{asset("AdminLTE/plugins/jquery/jquery.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/jquery-ui/jquery-ui.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/sparklines/sparkline.js")}}></script>
  <script src={{asset("AdminLTE/plugins/jquery-knob/jquery.knob.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/moment/moment.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/daterangepicker/daterangepicker.js")}}></script>
  <script src={{asset("AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/summernote/summernote-bs4.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables/jquery.dataTables.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js")}}></script>
  <script src={{asset("AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js")}}></script>
  <script src={{asset("AdminLTE/dist/js/adminlte.js")}}></script>
  <script src={{asset("js/numeral.js")}}></script>
  {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script> --}}
  <script src={{asset("js/custom.js")}}></script>

  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher(`{{config('broadcasting.connections.pusher.key')}}`, {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      $("#data-order").append(`<span class="badge badge-warning right">${ data.message }</span>`);
      // alert(JSON.stringify(data));
    });
  </script>

</body>

</html>
