@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Parking</h4>
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
                        $data = $parkings->map(function ($parking) {
                            return (object)[
                                'id' => $parking->id,
                                'building' => $parking->building->name,
                                'unit_number' => $parking->unit->unit_number,
                                'plan'        => $parking->plan,
                                'start_date'  => $parking->start_date,
                                'license_plate'=> $parking->license_plate,
                                'email'       => $parking->email ?? 'N/A',
                                'phone_number'=> $parking->phone_number ?? 'N/A' 
                            ];
                        });
                        @endphp
                        <div class="card-body">
                            @php
                                $columns = ['building', 'unit_number', 'plan', 'start_date', 'license_plate', 'email', 'phone_number'];
                            @endphp
                            <x-data-table :data="$data" :columns="$columns" />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
