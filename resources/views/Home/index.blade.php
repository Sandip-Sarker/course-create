@extends('master')

@section('content')
    <h3 class="mx-5 text-success">Create Course</h3>
    <div class="card card-body w-75 shadow mx-auto mt-5 mb-5">
    <div class="container mt-4">
    <div class="col-sm-12">
      {{-- Error massge show --}}
      @if ($errors->any())
    <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
    @endif

      <form action="{{route('course.store')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Course Info -->
      <div class="mb-3">
      <label class="form-label">Course Title <span class="text-danger">*</span></label>
      <input type="text" name="title" value="{{old('title')}}" class="form-control">
      </div>
      <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" value="{{old('description')}}" rows="3"></textarea>
      </div>
      <div class="mb-3">
      <label class="form-label">Category <span class="text-danger">*</span> </label>
      <input type="text" name="category" value="{{old('category')}}" class="form-control">
      </div>

      <!-- Modules Section -->
      <h4>Modules</h4>
      <div id="modules-wrapper"></div>

      <button type="button" class="btn btn-outline-primary mt-2" onclick="addModule()">+ Add Module</button>

      <div class="mt-4">
      <button type="submit" class="btn btn-success">Create Course</button>
      </div>
      </form>
      </div>
    </div>
    </div>

    <!-- Hidden Templates -->
    <template id="module-template">
    <div class="row">
    <div class="col-sm-12">
      <div class="card my-3 module-card">
      <div class="card-body">
      <div class="d-flex justify-content-between">
      <h5>Module <span class="text-danger">*</span></h5>
      <button type="button" class="btn btn-sm btn-danger" onclick="removeModule(this)">Remove</button>
      </div>

      <div class="mb-3">
      <label class="form-label">Module Title <span class="text-danger">*</span></label>
      <input type="text" name="modules[__INDEX__][title]" class="form-control">
      </div>

      <div class="content-wrapper"></div>
      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addContent(this)">+ Add Content</button>
      </div>
      </div>
    </div>
    </div>
    </template>

    <template id="content-template">
    <div class="row">
      <div class="col-sm-12">
        <div class="border rounded p-2 mb-2 content-block">
        <div class="d-flex justify-content-between align-items-center">
          <button type="button" class="btn-close" onclick="removeContent(this)"></button>
        </div>
        <div class="row mt-2">

          <div class="col-md-4">
          <strong>Title <span class="text-danger">*</span></strong>
          <input type="text" class="form-control" name="modules[__M_INDEX__][contents][__C_INDEX__][title]"
            placeholder="Title">
          </div>

          <div class="col-md-4">
          <strong>Video Type</strong>
          <input type="text" class="form-control" name="modules[__M_INDEX__][contents][__C_INDEX__][video_type]"
            placeholder="Video Type">
          </div>

          <div class="col-md-4">
          <strong>Video Length</strong>
          <input type="text" class="form-control" name="modules[__M_INDEX__][contents][__C_INDEX__][video_length]"
            placeholder="Video Length">
          </div>

          <div class="col-md-6">
          <strong>Video Url</strong>
          <input type="text" class="form-control" name="modules[__M_INDEX__][contents][__C_INDEX__][video_url]"
            placeholder="Video Url">
          </div>

          <div class="col-md-6">
          <strong>Image</strong>
          <input type="file" class="form-control" name="modules[__M_INDEX__][contents][__C_INDEX__][image]">
          </div>

        </div>
        </div>
      </div>
    </div>
    </template>

@endsection


<script>
  let moduleIndex = 0;

  function addModule() {
    const template = $('#module-template').html().replace(/__INDEX__/g, moduleIndex);
    const $module = $(template);
    $('#modules-wrapper').append($module);
    moduleIndex++;
  }

  function removeModule(btn) {
    $(btn).closest('.module-card').remove();
  }

  function addContent(btn) {
    const $moduleCard = $(btn).closest('.module-card');
    const $wrapper = $moduleCard.find('.content-wrapper');
    const moduleIdx = $('#modules-wrapper .module-card').index($moduleCard);
    const contentIndex = $wrapper.children().length;

    const template = $('#content-template').html()
      .replace(/__M_INDEX__/g, moduleIdx)
      .replace(/__C_INDEX__/g, contentIndex);

    const $content = $(template);
    $wrapper.append($content);
  }

  function removeContent(btn) {
    $(btn).closest('.content-block').remove();
  }
</script>