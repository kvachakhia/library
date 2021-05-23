@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class=col-md-12>

                <div id="form-list-client">
                    <legend>List of Books</legend>

                    @if (auth()->user()->is_admin == 1)
                        <div class="pull-right">
                            <a href="{{ route('admin.book.create') }}" class="btn btn-default-btn-xs btn-success"> New</a>
                        </div>
                    @endif
                    <br>

                    <form action="{{ route('page.search_books') }}" method="GET">
                        <div class="form-group">
                            <label for="author_id">Select Author(s)</label>
                            <select class="author_id" name="author_id[]" style="width: 50%" multiple>
                                @foreach ($authors as $author)
                                    @php
                                        $selected = '';
                                        if (in_array($author->id, $_GET['author_id'])) {
                                            $selected = 'selected="selected"';
                                        }
                                    @endphp
                                    <option value="{{ $author->id }}" {{ $selected }}>{{ $author->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>


                    <br>
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <th>Image</th>
                                <th>Audio</th>
                                <th>Author</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody id="form-list-client-body">
                            @foreach ($books as $key => $book)


                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td><img src="{{ Storage::url($book->image) }}" width="150"></td>
                                    <td>
                                        <audio controls>
                                            <source src="{{ Storage::url($book->audio) }}" type="audio/ogg">
                                            <source src="{{ Storage::url($book->audio) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </td>
                                    <td>
                                        @foreach ($book->authors as $author)
                                            {{ $author->name }}{{ $loop->last ? '' : ',' }}
                                        @endforeach
                                    </td>
                                    <td>{{ $book->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.book.edit', $book->id) }}"
                                            class="btn btn-default btn-sm "> <i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.book.destroy', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-default btn-sm "> <i
                                                    class="far fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.author_id').select2();
        });

    </script>
@endsection
