@extends('adminlte.master')

@section('content')
    <a href="/questions/create" class="btn btn-primary mb-3">Create questions!</a>
    @foreach ($questions as $key => $q)
      <div class="card text-left">
        <div class="card-body">
          <h3><b>{{ $q->judul }}</b></h3>
          <p class="card-text">{!! $q->isi !!}</p>
          <p class=" text-muted">Tanggal dibuat : {{ $q->created_at }}</p>
        </div>
        <div class="card-footer">
          <a href="/answers/{{ $q->id }}" class="btn btn-success btn-sm">Show answers</a>
          <a href="/questions/{{ $q->id }}" class="btn btn-primary btn-sm">Detail questions</a>
          <a href="/questions/{{ $q->id }}/edit" class="btn btn-primary btn-sm">Edit questions</a>
          <form action="/questions/{{ $q->id }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="d-inline-block btn btn-danger btn-sm ">Delete questions</button>
          </form>
        </div>
      </div>
    @endforeach
@endsection