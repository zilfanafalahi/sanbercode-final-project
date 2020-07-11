@extends('adminlte.master')

@section('content')
    <a href="/questions/create" class="btn btn-primary mb-3">Create questions!</a>
    @foreach ($questions as $key => $q)
      <div class="card text-left">
        <div class="card-body">
          <div class="row">
            <h3><b>{{ $q->judul }}</b></h3>
            <button class="btn btn-primary ml-auto mr-2" id="cart">Vote : (<span id="jumlah">{{ $poin[$q->id] }}</span>)</button>
            @if (($reputasi < 15) || ($q->users_id == Auth::id()) || ($voted[$q->id] == 1))
              <a class="btn btn-success mr-2 disabled">Upvote</a>
              <a class="btn btn-danger mr-2 disabled">Downvote</a>
            @else
              @if ($voted[$q->id] == -1)
                <a href="/questions/upvotes/{{ $q->id }}" onClick="upvote();" class="btn btn-success mr-2">Upvote</a>
                <a class="btn btn-danger mr-2 disabled">Downvote</a>
              @else
                <a href="/questions/upvotes/{{ $q->id }}" onClick="upvote();" class="btn btn-success mr-2">Upvote</a>
                <a href="/questions/downvotes/{{ $q->id }}" onClick="downvote();" class="btn btn-danger mr-2">Downvote</a>
              @endif
            @endif
          </div>
          <p class="card-text">{!! $q->isi !!}</p>
          <p class=" text-muted">Tanggal dibuat : {{ $q->created_at }}</p>
        </div>
        <div class="card-footer">
          <a href="/answers/{{ $q->id }}" class="btn btn-success btn-sm">Show answers</a>
          <a href="/questions/{{ $q->id }}" class="btn btn-primary btn-sm">Detail questions</a>
          @if(Auth::check() && (Auth::user()->id == $q->users_id)) 
            <a href="/questions/{{ $q->id }}/edit" class="btn btn-primary btn-sm">Edit questions</a>
            <form action="/questions/{{ $q->id }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="d-inline-block btn btn-danger btn-sm ">Delete questions</button>
            </form>
          @endif
        </div>
      </div>
    @endforeach
@endsection

@push('scripts-footer')
  <script>
    function reputasi() {
      document.getElementById("reputasi").innerHTML = "Your Reputations : {{ $reputasi }}";
    }
    reputasi();
  </script>
  <script>
    // increment upvote
    
    var add = document.getElementById("upvote")

    function upvote(add) {
      var num = parseInt(document.getElementById("jumlah").innerHTML);
      const test = true;
      add = test ? num++ : num--;
      document.getElementById("jumlah").innerHTML = num;
    }

    // decrement upvote
    var add = document.getElementById("downvote")

    function downvote(add) {
      var num = parseInt(document.getElementById("jumlah").innerHTML);
      const test = false;
      add = test ? num++ : num--;
      document.getElementById("jumlah").innerHTML = num;
    }
  </script>
@endpush