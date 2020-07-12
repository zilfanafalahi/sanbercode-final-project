@extends('adminlte.master')

@push('scripts-header')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
  <div class="card text-left">
    <div class="card-body">
        <div class="row">
            <h3><b>{{ $question->judul }}</b></h3>
            <a href="/questions" class="btn btn-warning ml-auto">Kembali</a>
        </div>
      @foreach (explode(' ', $question->tag) as $tag)
        <span class="badge badge-success badge-pill">{{ $tag }}</span>
      @endforeach
      <p class="card-text">{!! $question->isi !!}</p>
      <div class="row">
        <a href="/questions/{{$question->id}}/comments" class="btn btn-info btn-sm ml-auto">Show Comments</a>
      </div>
    </div>
    <div class="card-footer text-muted">
      Tanggal Dibuat : {{ $question->created_at }} -
      Tanggal Diperbaharui : {{ $question->updated_at }}
    </div>
  </div>
  

  @if (count($answers) > 0)
    @foreach ($answers as $answer)
        <div class="card text-left my-2">
            <div class="card-body">
              <div class="row">
                <h4><b>Jawaban #{{ $answer->id }}</b></h4>
                <h6><b><span id="best" class="text-danger ml-2"></span></b></h6>
                <button class="btn btn-primary ml-auto mr-2" id="cart">Vote : (<span id="jumlah">{{ $poin[$answer->id] }}</span>)</button>
                @if (($reputasi < 15) || ($answer->answer_user_id == Auth::id()) || ($voted[$answer->id] == 1))
                  <a class="btn btn-success mr-2 disabled">Upvote</a>
                  <a class="btn btn-danger mr-2 disabled">Downvote</a>
                @else
                  @if ($voted[$answer->id] == -1)    
                    <a class="btn btn-success mr-2 disabled">Upvote</a>
                    <a class="btn btn-danger mr-2 disabled">Downvote</a>
                  @else
                    <a href="/answers/upvotes/{{ $question->id }}/{{ $answer->id }}" onClick="upvote();" class="btn btn-success mr-2">Upvote</a>
                    <a href="/answers/downvotes/{{ $question->id }}/{{ $answer->id }}" onClick="downvote();" class="btn btn-danger mr-2">Downvote</a>
                  @endif
                @endif
                <button onClick="bestanswer();" class="btn btn-danger mr-2">Best Answers</button>
                @if ($answer->ketepatan_jawaban == 'ya')
                  <div class="btn btn-success mr-2">Jawaban Tepat</div>
                @endif
              </div>   
              <p class="card-text">{!! $answer->isi !!}</p>
              
            </div>
            <div class="card-footer">
              <div>
                <a href="/answers/{{$question->id}}/{{$answer->id}}/comments" class="btn btn-secondary mr-1 btn-sm">Show Comments</a>
                @if(Auth::check() && (Auth::user()->id == $answer->answer_user_id)) 
                  <a href="/answers/{{$question->id}}/{{$answer->id}}/edit" class="btn mr-1 btn-primary btn-sm">Edit</a>
                  <form action="/answers/{{$question->id}}/{{$answer->id}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn mr-1 btn-danger btn-sm">Delete</button>
                  </form>
                @endif
                
              </div>
            </div>
        </div>
    @endforeach
  @endif

  


  {{-- form untuk isi jawaban --}}
  <form action="/answers/{{ $question->id }}" method="POST">
    @csrf
    <div class="form-group mt-3">
      <label for="isi">Tambahkan Jawaban</label>
      <textarea name="isi" class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

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
    break;
  }

  // decrement upvote
  var add = document.getElementById("downvote")

  function downvote(add) {
    var num = parseInt(document.getElementById("jumlah").innerHTML);
    const test = false;
    add = test ? num++ : num--;
    document.getElementById("jumlah").innerHTML = num;
    break;
  }
</script>

<script>
  function bestanswer() {
    document.getElementById("best").innerHTML = '(Best Answer)';
  }
</script>

<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
@endpush