@extends('admin.master')

@section('title')
    {{ $siteSettings->title }} | Privacy Policy Page Settings
@endsection

@section('content')

    <section class="container-fluid">
        <form action="{{ route('update-privacyPage') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="id" value="3" style="display: none">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label"> Privacy Policy Page Content </label>
                        <textarea id="editor" name="content" class="form-control">{!! $privacy->content !!}</textarea>
                    </div>
                </div>
                @if (Auth::guard('admin')->user()->access->pages_manage == 3)
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit"> Save Settings </button>
                </div>
                @endif
            </div>
        </form>
    </section>

@endsection

@section('customjs')
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ),{
                ckfinder: {
                    uploadUrl: "{{ route('ck.upload',['_token'=> csrf_token()]) }}",
                }
            } )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
