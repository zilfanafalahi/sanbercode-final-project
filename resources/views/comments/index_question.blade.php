@extends('adminlte.master')

@push('scripts-header')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
  <div class="card text-left">
    <div class="card-body">
      <div class="row">
        <h3><b>{{ $question->judul }}</b></h3>
        <a href="/answers/{{$question->id}}" class="btn btn-warning ml-auto">Kembali</a>
      </div>
      @foreach (explode(' ', $question->tag) as $tag)
        <span class="badge badge-success badge-pill">{{ $tag }}</span>
      @endforeach
      <p class="card-text">{!! $question->isi !!}</p>
    </div>
    <div class="card-footer text-muted">
      Tanggal Dibuat : {{ $question->created_at }} -
      Tanggal Diperbaharui : {{ $question->updated_at }}
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
                <div class="card bg-light">
                    <div class="card-body">
                        <i>{!! $item->isi !!}</i>
                    </div> 
                    @if(Auth::check() && (Auth::user()->id == $item->comment_user_id)) 
                      <div class="card-footer">
                        <a href="comments/{{$item -> id}}/edit" class="btn mr-1 btn-primary btn-sm">Edit</a>
                        <form action="comments/{{$item -> id}}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn mr-1 btn-danger btn-sm">Delete</button>
                        </form>
                      </div>
                    @endif
                </div>
        @endforeach
    @else
        <div class="card bg-light">
            <div class="card-body">
                <i>There is no comment... Make One Below..</i>
            </div>
        </div>
    @endif
        <div class="card bg-light">
            <div class="card-body">
                <form action="/questions/{{$question->id}}/comments" method="post">
                    @csrf
                    <div class="form-group">
                      <textarea class="form-control my-editor" name="isi" rows="3" placeholder="Write Your Comment Here.. :') "></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection

@push('scripts-footer')
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