@extends('admin.master')

@section('title')
    {{ $siteSettings->title }} | Footer Settings
@endsection

@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Footer Settings</h1>
        </div>
        @include('admin.auth.message')
        <div class="row ">
            <div class="col-md-12">
                <form method="post" action="{{ route('updateFooterSettings') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siteSettings->id }}">
                    <div class="card" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">Footer</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>App Store Link</label>
                                    <input type="text" name="appStoreLink" class="form-control" value="{{ $siteSettings->appStoreLink }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Google Play Store Link</label>
                                    <input type="text" name="googleStoreLink" class="form-control" value="{{ $siteSettings->googleStoreLink }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $siteSettings->address }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>E-mail</label>
                                    <input type="text" name="email" class="form-control" value="{{ $siteSettings->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Facebook</label>
                                    <input type="text" name="facebook" class="form-control" value="{{ $siteSettings->facebook }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Twitter</label>
                                    <input type="text" name="twitter" class="form-control" value="{{ $siteSettings->twitter }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Instagram</label>
                                    <input type="text" name="instagram" class="form-control" value="{{ $siteSettings->instagram }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Youtube</label>
                                    <input type="text" name="youtube" class="form-control" value="{{ $siteSettings->youtube }}">
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h4 class="">Payment Image</h4>
                                        <img src="{{ asset($siteSettings->paymentImage) }}" class="w-50 py-3">
                                        <input type="file" name="paymentImage" accept="image/*">
                                    </div>
                                </div>
                                @if (Auth::guard('admin')->user()->access->settings == 3)
                                <div class="col-md-12" style="padding: 30px 10px 0px 10px">
                                    <button type="submit" class="btn btn-primary">Save settings</button>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>


    </div>

@endsection
