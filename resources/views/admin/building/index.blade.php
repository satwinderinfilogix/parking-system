@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Buildings</h4>
                        <div class="page-title-right">
                            <a href="{{ route('building.create') }}" class="btn btn-primary">Add New Building</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />
                    <div class="card">
                        <div class="card-body">
                            @php
                                $columns = ['name'];
                                $editRoute = 'building.edit'; 
                                $deleteRoute = 'building.destroy'; 
                            @endphp
                            <x-data-table :data="$data" :columns="$columns" :editRoute="$editRoute" :deleteRoute="$deleteRoute" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
