@extends('admin.master')

@section('title')
    {{ $siteSettings->title }} | Header Settings
@endsection

@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Header Settings</h1>
        </div>
        @include('admin.auth.message')
        <div class="row ">
            <div class="col-md-12">
                <form method="post" action="{{ route('updateSiteSettings') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siteSettings->id }}">
                    <div class="card" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <h4 class="">Logo</h4>
                                        <img src="{{ asset($siteSettings->logo) }}" class="w-50 py-3" height="150px">

                                        <input type="file" name="logo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h4>Favicon</h4>
                                        <img src="{{ asset($siteSettings->favicon) }}" class="py-3" height="150px"><br>

                                        <input type="file" name="favicon" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Site Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $siteSettings->title }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Site Tagline</label>
                                    <input type="text" name="tagline" class="form-control" value="{{ $siteSettings->tagline }}">
                                </div>
                                @if (Auth::guard('admin')->user()->access->settings == 3)
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Save settings</button>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </form>
                <form method="post" action="{{ route('updateHeaderSettings') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siteSettings->id }}">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-black">Heading Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $siteSettings->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label>Location Link</label>
                                        <input type="text" name="locationLink" class="form-control" value="{{ $siteSettings->locationLink }}">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Offer One Text</label>
                                    <input type="text" name="offerOne" class="form-control" value="{{ $siteSettings->offerOne }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Offer Link</label>
                                    <input type="text" name="offerOneLink" class="form-control" value="{{ $siteSettings->offerOneLink }}">
                                </div>
                                <div class="col-md-6 ">
                                    <label>Offer Two Text</label>
                                    <input type="text" name="offerTwo" class="form-control" value="{{ $siteSettings->offerTwo }}">
                                </div>
                                <div class="col-md-6 ">
                                    <label>Offer Link</label>
                                    <input type="text" name="offerTwoLink" class="form-control" value="{{ $siteSettings->offerTwoLink }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Hotline Number</label>
                                    <input type="text" name="hotline" class="form-control" value="{{ $siteSettings->hotline }}">
                                </div>
                                @if (Auth::guard('admin')->user()->access->settings == 3)
                                <div class="col-md-12 " style="padding-bottom: 0px !important;">
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
