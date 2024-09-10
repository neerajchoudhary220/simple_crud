@extends('crud_master.master')
@section('contents')
        @include('crud.table')
@endsection
@push('custom-js')
<script>
    const listuRL = "{{ route('crud.list') }}";
    window.dt_tbl =''
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            }
        })
    })
</script>
<script src="{{ asset('assets/js/crud/simple-crud.js') }}"></script>
@endpush
