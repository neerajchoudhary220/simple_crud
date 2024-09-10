@extends('crud_master.master')
@section('contents')
    <div class="card mb-3">
        <div class="card-header">
            <a href="{{ route('crud') }}" class="btn btn-warning text-white">Back</a>
        </div>
        <div class="card card-body">
            @if (isset($student))
            {{ html()->model($student)->form('POST',$form_route)->attributes(['enctype'=>'multipart/form-data'])->open() }}
                @else
            {{ html()->form('POST',$form_route)->attributes(['enctype'=>'multipart/form-data'])->open() }}

            @endif

            <div class="row mb-2 mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label('Name')->for('name') }}<span class="text-danger">*</span>
                        {{ html()->input('text', 'name', null)->attributes(['class' => 'form-control', 'placeholder' => 'Name']) }}
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label('Email')->for('email') }}<span class="text-danger">*</span>
                        {{ html()->input('text', 'email', null)->attributes(['class' => 'form-control', 'placeholder' => 'example@mail.com']) }}
                        @error('email')
                    <span class="text-danger">{{ $message }}</span>

                        @enderror
                    </div>

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->input('file', 'image')->attributes(['id' => 'image', 'accept' => 'image/jpeg', 'image/jpg', 'image/png']) }}
                    </div>
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                        
                    @enderror

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group text-right">
                        {{ html()->submit('Save')->attributes(['class' => 'btn btn-success']) }}
                        {{ html()->reset('Reset')->attributes(['class' => 'btn btn-danger rstBtn']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ html()->form()->close() }}

    </div>
    </div>
@endsection
