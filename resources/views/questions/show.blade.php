@extends('adminlte.master')

@section('content')
  <div class="card text-left">
    <div class="card-body">
      <h3><b>{{ $questions->judul }}</b></h3>
      @foreach (explode(' ', $questions->tag) as $tag)
        <span class="badge badge-success badge-pill">{{ $tag }}</span>
      @endforeach
      <p class="card-text">{!! $questions->isi !!}</p>
    </div>
    <div class="card-footer text-muted">
      Tanggal Dibuat : {{ $questions->created_at }} -
      Tanggal Diperbaharui : {{ $questions->updated_at }}
    </div>
  </div>
  <a href="/questions" class="btn btn-warning">Kembali</a>
@endsection