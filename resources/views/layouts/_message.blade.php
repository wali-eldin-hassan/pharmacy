@if(session()->has('success'))
    <script>
        toastr.success(' {{session()->get('success')}}');
    </script>

@elseif(session()->has('warning'))
    <script>
        toastr.warning('{{session()->get('warning')}}');
    </script>
@endif
@if(count($errors) > 0)
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}');
        @endforeach
    </script>
@endif
