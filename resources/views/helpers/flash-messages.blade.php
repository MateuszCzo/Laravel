@if(session('status'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        </div>
    </div>
@endif