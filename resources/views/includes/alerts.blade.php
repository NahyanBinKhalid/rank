@if(Session::has('primary'))
    <div class="alert alert-primary" role="alert">
        <strong>Alert!</strong>
        {{ Session::get('primary') }}
    </div>
@endif
@if(Session::has('secondary'))
<div class="alert alert-secondary" role="alert">
    <strong>Alert!</strong>
    {{ Session::get('secondary') }}
</div>
@endif
@if(Session::has('light'))
<div class="alert alert-light" role="alert">
    <strong>Alert!</strong>
    {{ Session::get('light') }}
</div>
@endif
@if(Session::has('dark'))
<div class="alert alert-dark" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Alert!</strong>
    {{ Session::get('dark') }}
</div>
@endif
@if(Session::has('dark'))
<div class="alert alert-danger" role="alert">
    <strong>Danger!</strong>
    {{ Session::get('danger') }}
</div>
@endif
@if(Session::has('info'))
<div class="alert alert-info" role="alert">
    <strong>Info!</strong>
    {{ Session::get('info') }}
</div>
@endif
@if(Session::has('warning'))
<div class="alert alert-warning" role="alert">
    <strong>Warning!</strong>
    {{ Session::get('warning') }}
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    <strong>Success!</strong>
    {{ Session::get('success') }}
</div>
@endif
