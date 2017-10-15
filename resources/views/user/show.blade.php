@extends('layouts.dashboard')

@section('title', 'Show User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">User information</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                            <img class="img-circle"
                                 src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100"
                                 alt="User Pic">
                        </div>
                        <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                            <img class="img-circle"
                                 src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=50"
                                 alt="User Pic">
                        </div>
                        <div class="col-md-9 col-lg-9 hidden-xs hidden-sm">
                            <strong>{{ $user->name }}</strong><br>
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>User role:</td>
                                    <td>{{ $user->roleString() }}</td>
                                </tr>
                                <tr>
                                    <td>Registered since:</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Updated at:</td>
                                    <td>{{ $user->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Timezone:</td>
                                    <td>{{ $user->timezone }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-sm btn-primary" type="button" title="E-mail this user" href="mailto:{{ $user->email }}"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <a class="btn btn-sm btn-warning" type="button" title="Edit this user" href="\user\{{ $user->id }}\edit"><i class="glyphicon glyphicon-edit"></i></a>
                        <a class="btn btn-sm btn-danger" type="button" title="Remove this user" href="\user\{{ $user->id }}\remove"><i class="glyphicon glyphicon-remove"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush


@push('scripts')
@endpush
