@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
                <form action="{{ url('/contact')}}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="content" id="" class="form-control cols='30' rows='10'"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection
