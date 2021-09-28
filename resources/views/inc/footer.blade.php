<!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; All rights reserved </strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/js/toastr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.selectable').select2();
</script>
<script>
    $('.datePicker').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
</script>
@if(Session::has('error_message'))
    <script>
        toastr.error("{{ Session::get('error_message') }}")
    </script>
@endif
@if(Session::has('message'))
    <script>
        toastr.success("{{ Session::get('message') }}")
    </script>
@endif
@yield('scripts')
</body>
</html>
