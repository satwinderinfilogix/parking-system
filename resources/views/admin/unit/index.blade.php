@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Units</h4>
                        <div class="page-title-right">
                            <a href="{{ route('unit.create') }}" class="btn btn-primary">Add New Units</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />
                    <div class="card">
                        @php 
                        $data = $units->map(function ($unit) {
                            return (object)[
                                'id' => $unit->id,
                                'name' => $unit->name,
                                'building' => $unit->building->name
                            ];
                        });
                        @endphp
                        <div class="card-body">
                            @php
                                $columns = ['name','building'];
                                $editRoute = 'unit.edit'; 
                                $deleteRoute = 'unit.destroy'; 
                            @endphp
                            <x-data-table :data="$data" :columns="$columns" :editRoute="$editRoute" :deleteRoute="$deleteRoute" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
