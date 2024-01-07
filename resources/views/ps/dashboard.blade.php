@extends('ps.layouts.template')

@section('content')
    @if (Session::get('alreadyAccess'))
        <div class="alert alert-danger">{{ Session::get('alreadyAccess') }}</div>
    @endif
    <div class="jumbroton py-2 px-3">
        <h4 class="display" style="color: black;">
            Dashboard
        </h4>
        <p style="color: black;">Home / Dashboard</p>
        <br>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col" style="height: 150px">
              <div class="card h-100 shadow p-1 mb-4 border-0">
                <div class="card-body">
                  <h5 class="card-title">Peserta Didik Rayon {{ $rayon->rayon }}</h5>
                  <p class="card-text" style="margin-top: 8%; font-size: 1.5rem;">
                    <i class="fi fi-sr-user" style="margin-right:20px;"></i>
                    {{ $student }}
                  </p>                
                </div>
              </div>
            </div>
            <div class="col" style="height: 180px">
              <div class="card h-100 shadow p-1 mb-4 border-0">
                <div class="card-body">
                  <h5 class="card-title">Keterlambatan {{ $rayon->rayon }} Hari Ini</h5>
                  <b><?php echo strftime(" %d %B %Y"); ?></b>
                  <p class="card-text" style="margin-top: 8%; font-size: 1.5rem;">
                    <i class="fi fi-sr-user" style="margin-right:20px;"></i>
                    {{ $totalLateStudents }} 
                  </p>
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .jumbroton.py-2.px-3 h4 p{
        color: black;
    }
</style>