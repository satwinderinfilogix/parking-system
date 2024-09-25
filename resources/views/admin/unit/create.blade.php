@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create a unit</h4>

                        <div class="page-title-right">
                            <a href="{{ route('unit.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to units</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add a unit</h4>
                            <form action="{{ route('unit.store') }}" method="post">
                                @csrf
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <label for="basicpill-building">Building</label>
                                        <select class="form-control select2" name="building_id">
                                            <option value="" disabled selected>Select Building</option>
                                            @foreach ($buildings as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('building_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form-input name="unit_number" value="{{ old('unit_number') }}" label="Unit Number" placeholder="Enter Unit Number"/>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <x-form-input name="security_code" value="{{ old('security_code') }}" label="Security Code" placeholder="Enter Security Code"/>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </div>
                            </form>    
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
@endsection