@extends('ps.layouts.template')

@section('content')
    <div class="jumbroton py-2 px-1">
        <h4 class="display" style="color: black;">
            Data Keterlambatan
        </h4>
        <p style="color: black;">
          <a class="button_waterpump" style="color: black;" href="/pembimbing/dashboard">Home</a> /
          <a class="button_waterpump" style="color: black;">Data Keterlambatan</a>
        </p>
        <a href="{{ route('pembimbing.late.export-excel') }}" class="btn btn-info" style="color: white">Export Data Keterlambatan</a>

        <br>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>    
    @endif
    <div class="table shadow p-1 mb-4 border-0" style="background-color: white">
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="">Keseluruhan Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('pembimbing.late.rekap')}}">Rekapitulasi Data</a>
            </li>
          </ul>
          <br>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Informasi</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $no = 0;
                @endphp
                @foreach ($late as $lates)
              <tr>
                <th scope="row">{{ ++$no  }}</th>
                <td>{{ $lates->student->nis}}
                    <br>
                    {{ $lates->student->name }}</td>
                <td>{{ $lates->date_time_late }}</td>
                <td>{{ $lates->information }}</td>                
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
@endsection

<style>
    .btn {
        border: none;
        background-color: inherit;
        padding: 14px 28px;
        font-size: 16px;
        cursor: pointer;
        display: inline-block;
    }

    .jumbroton.py-2.px-1 p a {
        text-decoration: none;
    }
</style>