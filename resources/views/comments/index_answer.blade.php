@extends('adminlte.master')

@section('content')
    <div class="card text-left">
        <div class="card-body">
            <div class="row">
                <h3><b>{{ $question->judul }}</b></h3>
                <a href="/answers/{{ $question->id }}" class="btn btn-warning ml-auto">Kembali</a>
            </div>
            <p class="card-text">{!! $question->isi !!}</p>
            <div class="row">
                @foreach (explode(' ', $question->tag) as $tag)
                <button class="btn btn-success btn-sm mx-1">{{ $tag }}</button>
                @endforeach
                <a href="/questions/{{$question->id}}/comments" class="btn btn-info ml-auto">Show Comments</a>
            </div>
        </div>
        <div class="card-footer text-muted">
        Tanggal Dibuat : {{ $question->created_at }} -
        Tanggal Diperbaharui : {{ $question->updated_at }}
        </div>
    </div>
  
    <div class="card text-left my-2">
        <div class="card-body">
            <h4><b>Jawaban #{{ $answer->id }}</b></h4>
            <p class="card-text">{!! $answer->isi !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="bg-transparent d-flex justify-content-center">
                <i class="fa fa-quote-right fa-align-center mt-3" aria-hidden="true" ></i>
            </div>
        </div>
        <div class="col-md-11">
        @if (count($comments) > 0)
            @foreach ($comments as $item)
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <i>{{ $item->isi }}</i>
                        </div>
                    </div>
            @endforeach
        @else
            <div class="card bg-secondary">
                <div class="card-body">
                    <i>There is no comment... Make One Below..</i>
                </div>
            </div>
        @endif
            <div class="card bg-light">
                <div class="card-body">
                    <form action="/answers/{{$question->id}}/{{$answer->id}}/comments" method="post">
                        @csrf
                        <div class="form-group">
                          <textarea class="form-control" name="isi" rows="3" placeholder="Write Your Comment Here.. :') "></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
@endsection