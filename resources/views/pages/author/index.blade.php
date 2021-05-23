@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class=col-md-12>

                <div id="form-list-client">
                    <legend>List of Authors</legend>

                    @if (auth()->user()->is_admin == 1)

                        <div class="pull-right">
                            <a href="{{ route('admin.author.create') }}" class="btn btn-default-btn-xs btn-success">
                                New</a>
                        </div>
                    @endif

                    <br>
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <th>Biography</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody id="form-list-client-body">
                            @foreach ($authors as $key => $author)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $author->name }}</td>
                                    <td>{{ Str::limit($author->biography, 100) }}
                                    </td>
                                    <td>{{ $author->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.author.edit', $author->id) }}"
                                            class="btn btn-default btn-sm "> <i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.author.destroy', $author->id) }}" method="POST">
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
@endsection
