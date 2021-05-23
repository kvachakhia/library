@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <form action="{{ route('admin.author.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="author_name">Author Name</label>
                        <input type="text" class="form-control" name="author_name" id="author_name"
                            value="{{ old('author_name') }}" placeholder="Enter Author Name">
                    </div>

                    <div class="form-group">
                        <label for="author_name">Biography</label>
                        <textarea name="biography" class="form-control" id="" cols="30"
                            rows="10">{{ old('biography') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


            </div>

        </div>
    </div>
    </div>
@endsection
