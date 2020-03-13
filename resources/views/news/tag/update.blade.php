@extends('includes.default')
@section('title', 'Update | Bareksa')
@section('content')
<!-- Main Content -->
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <form class="col-lg-12" action="" method="post">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="card">
                      <div class="card-header">
                        {{ $title_form }}
                    </div>
                    <div class="card-body card-block">
                        <div class="form-group {{ $errors->has('tag_name') ? 'has-error' : '' }}">
                            <label for="tag_name" class=" form-control-label">Name</label>
                            <input oninput="inputName()" id="inputTagName" type="text" name="tag_name" placeholder="Nama Tag" class="form-control" @if(!empty($tag)) value="{{ $tag->name}}" @else value="{{ old('tag_name') }}" @endif>
                              @if(!empty($errors->first('tag_name')))
                              <span class="help-block">{{ $errors->first('tag_name') }}</span>
                              @endif
                            
                        </div>
                        <div class="form-group {{ $errors->has('tag_slug') ? 'has-error' : '' }}">
                            <label for="tag_slug" class=" form-control-label">Slug</label>
                            <input id="inputTagSlug" type="text" name="tag_slug" placeholder="Slug" class="form-control" @if(!empty($tag)) value="{{ $tag->slug}}" @else value="{{ old('tag_slug') }}" @endif>
                              @if(!empty($errors->first('tag_slug')))
                              <span class="help-block">{{ $errors->first('tag_slug') }}</span>
                              @endif
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- /Main Content -->
@endsection