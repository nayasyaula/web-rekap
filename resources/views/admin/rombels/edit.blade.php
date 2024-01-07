@extends('admin.layouts.template')

@section('content')
    <div class="jumbroton py-2 px-1">
        <h4 class="display" style="color: black;">
            Edit Data Rombel
        </h4>
        <p style="color: black;">
            <a class="button_waterpump" style="color: black;" href="/admin/dashboard">Home</a> /
            <a class="button_waterpump" style="color: black;" href="{{ route('admin.rombel.home') }}">Data Rombel</a> /
            <a class="button_waterpump" style="color: black;">Edit Data Rombel</a>
        </p>
    </div>
    <br>
    @if (Session::get('success'))
            <div class="alert alert-success" {{ Session::get('success') }}></div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif 
    <form action="{{ route('admin.rombel.update' , $rombel['id'])}}" method="POST" class="card p-5 shadow p-1 mb-7 border-0" style="width: 80%">
        @csrf
        @method('PATCH')  
        <div class="mb-3 row">
            <label for="rombel" class="col-sm-2 col-form-label">Rombel</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rombel" name="rombel" value="{{ $rombel['rombel'] }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Edit Data</button>
    </form>
@endsection

<style>
    .jumbroton.py-2.px-1 p a {
        text-decoration: none;
    }
</style>