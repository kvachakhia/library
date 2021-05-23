@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <form action="{{ route('admin.book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="book_name">Book Name</label>
                        <input type="text" class="form-control" name="book_name" id="book_name" value="{{ $book->name }}"
                            placeholder="Enter Book Name" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" accept="image/*" class="form-control-file" id="image">
                        <br>
                        <img src="{{ Storage::url($book->image) }}" width="150">
                    </div>

                    <div class="form-group">
                        <label for="image">Audio File</label>
                        <input type="file" name="audio" accept="audio/*" class="form-control-file" id="aduio">
                        <br>
                        <audio controls>
                            <source src="{{ Storage::url($book->audio) }}" type="audio/ogg">
                            <source src="{{ Storage::url($book->audio) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>

                    

                    <label for="author_id">Select Author(s)</label>
                    <select class="author_id" name="author_id[]" style="width: 100%" multiple>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ $authorIds->contains($author->id) ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>

                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


            </div>

        </div>
    </div>
    </div>

    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {

            $('.author_id').select2();
        });

    </script>

@endsection
