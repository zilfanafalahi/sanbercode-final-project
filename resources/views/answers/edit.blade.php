@extends('adminlte.master')

@push('scripts-header')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
    <a href="/answers/{{ $question->id }}" class="btn btn-warning ml-auto mb-2">Kembali</a>
  <div class="card text-left">
    <div class="card-body">
        <div class="row">
            <h3><b>{{ $question->judul }}</b></h3>
        </div>
      <p class="card-text">{!! $question->isi !!}</p>
    </div>
    <div class="card-footer text-muted">
      Tanggal Dibuat : {{ $question->created_at }} -
      Tanggal Diperbaharui : {{ $question->updated_at }}
    </div>
  </div>

  {{-- form untuk edit jawaban --}}
  <form action="/answers/{{ $question->id }}/{{$answer->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mt-3">
        <label for="isi">Isi jawaban</label>
        <textarea name="isi" class="form-control my-editor">{!! $answer->isi !!}</textarea>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

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