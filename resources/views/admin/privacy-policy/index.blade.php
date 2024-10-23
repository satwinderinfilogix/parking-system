@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Privacy Policy</h4>
                    </div>
                </div>
            </div>
            <x-success-message :message="session('success')" />

            <div class="card mt-4">
                <div class="card-body">
                    <form action="{{ route('update.privacy.policy') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label style="font-size: 20px;">Privacy Policy</label>
                                <textarea name="content" id="editor1" rows="10" cols="80">{{$policy->content ?? ''}}</textarea>
                            </div>
                            <div class="col-12 mb-2">
                                <label style="font-size: 20px;">Disclaimer</label>
                                <textarea name="disclaimer" id="editor2" rows="10" cols="80">{{$policy->disclaimer ?? 'By providing my contact information, I acknowledge and give my explicit consent to be contacted via SMS and receive emails for various purposes, which may include marketing and promotional content. Message and data rates may apply. Message frequency may vary. Reply STOP to opt out. Refer to our <a href="/privacy-policy">Privacy Policy</a> for more information'}}</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary mt-2">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
        .create(document.querySelector('#editor1'))
        .catch(error => {
            console.error(error);
        });
        ClassicEditor
        .create(document.querySelector('#editor2'))
        .catch(error => {
            console.error(error);
        });
    </script>
@endsection
