@extends('adminlte.master')

@push('scripts-header')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
  <form action="/questions/{{ $questions->id }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label for="judul">Judul pertanyaan</label>
      <input type="text" class="form-control" id="judul" name="judul" value="{{ $questions->judul }}">
    </div>
    <div class="form-group">
      <label for="isi">Isi pertanyaan</label>
      <textarea name="isi" class="form-control my-editor">{!! $questions->isi !!}</textarea>
    </div>
    <div class="form-group">
      <label for="tag">Tag pertanyaan</label>
      <input type="text" class="form-control" id="tag" name="tag" value="{{ $questions->tag }}">
    </div>
    <a href="/questions" class="btn btn-warning">Kembali</a>
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