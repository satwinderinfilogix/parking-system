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
                            <form action="{{ route('unit.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="basicpill-building">Building</label>
                                        <select @class(["form-control select2", 'is-invalid' => $errors->has('building')]) name="building">
                                            <option value="" disabled selected>Select Building</option>
                                            @foreach ($buildings as $item)
                                                <option value="{{ $item->id }}" @selected(old('building') == $item->id)>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('building')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <x-form-input name="unit_number" value="{{ old('unit_number') }}" label="Unit Number" placeholder="Enter Unit Number"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <x-form-input name="security_code" value="{{ old('security_code') }}" label="Security Code" placeholder="Enter Security Code"/>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <x-form-input name="30_days_cost" value="{{ old('30_days_cost') }}" label="30 Days Cost" placeholder="Enter 30 Days Cost"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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