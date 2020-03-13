@extends('includes.default')
@section('title', 'Update | Bareksa')
@section('content')
{{--@if (count($errors) > 0)
  <div class="alert alert-danger alert-bean">
    <strong>{{ trans('validation.whoops') }} </strong> {{ trans('validation.input_error') }}<br /><br />
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif--}}
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
                        <div class="form-group {{ $errors->has('news_title') ? 'has-error' : '' }}">
                            <label for="news_title" class=" form-control-label">Title</label>
                            <input oninput="inputName()" id="inputTagName" type="text" name="news_title" placeholder="Title" class="form-control" @if(!empty($news)) value="{{ $news->title}}" @else value="{{ old('news_title') }}" @endif>
                              @if(!empty($errors->first('news_title')))
                              <span class="help-block">{{ $errors->first('news_title') }}</span>
                              @endif
                            
                        </div>
                        <div class="form-group {{ $errors->has('news_slug') ? 'has-error' : '' }}">
                            <label for="news_slug" class=" form-control-label">Slug</label>
                            <input id="inputTagSlug" type="text" name="news_slug" placeholder="Slug" class="form-control" @if(!empty($news)) value="{{ $news->slug}}" @else value="{{ old('news_slug') }}" @endif>
                              @if(!empty($errors->first('news_slug')))
                              <span class="help-block">{{ $errors->first('news_slug') }}</span>
                              @endif
                            
                        </div>
                        <div class="form-group {{ $errors->has('news_content') ? 'has-error' : '' }}">
                            <label for="news_content" class="form-control-label">Content</label>
                            <textarea class="form-control" name="news_content">
                                @if(!empty($news)) {{ $news->content}} @else {{ old('news_content') }} @endif
                            </textarea>
                              @if(!empty($errors->first('news_content')))
                              <span class="help-block">{{ $errors->first('news_content') }}</span>
                              @endif
                            
                        </div>

                        <div class="form-group">
                            <label for="news_topik" class=" form-control-label">Topik</label>
                            <select name="news_topik[]" class="selectpicker form-control" multiple data-live-search="true">
                                @if(!empty($news))
                                      @if($topik->count() > 0)
                                        @foreach($topik as $t)
                                        <option value="{{ $t->id }}" @if(in_array($t->id, $selected_topik)) selected @endif>{{ $t->name }}</option>
                                        @endforeach
                                      @endif
                                @else
                                      @if($topik->count() > 0)
                                        @foreach($topik as $t)
                                        <option value="{{ $t->id }}" @if(!empty(old('news_topik'))) @if(in_array($t->id, old('news_topik'))) selected @endif @endif>{{ $t->name }}</option>
                                        @endforeach
                                      @endif
                                @endif                              
                            </select>
                             @if(!empty($errors->first('news_topik')))
                              <span class="help-block">{{ $errors->first('news_topik') }}</span>
                              @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="news_tag" class=" form-control-label">Tag</label>
                            <select name="news_tag[]" class="selectpicker form-control" multiple data-live-search="true">
                                @if(!empty($news))
                                      @if($tag->count() > 0)
                                        @foreach($tag as $t)
                                        <option value="{{ $t->id }}" @if(in_array($t->id, $selected_tag)) selected @endif>{{ $t->name }}</option>
                                        @endforeach
                                      @endif
                                @else
                                      @if($tag->count() > 0)
                                        @foreach($tag as $t)
                                        <option value="{{ $t->id }}" @if(!empty(old('news_tag'))) @if(in_array($t->id, old('news_tag'))) selected @endif @endif>{{ $t->name }}</option>
                                        @endforeach
                                      @endif
                                @endif                              
                            </select>   
                            @if(!empty($errors->first('news_tag')))
                              <span class="help-block">{{ $errors->first('news_tag') }}</span>
                              @endif                         
                        </div>

                        <div class="form-group">
                            <label for="news_status" class=" form-control-label">Status</label>
                                <select name="news_status" id="select" class="form-control">
                                    <option data-tokens="1" value="1" @if(!empty($news)) @if($news->status == '1') selected='true' @endif @endif>Draft</option>
                                    <option data-tokens="2" value="2" @if(!empty($news)) @if($news->status == '2') selected='true' @endif @endif>Editor</option>
                                    <option data-tokens="3" value="3" @if(!empty($news)) @if($news->status == '3') selected='true' @endif @endif>Schedule</option>
                                    <option data-tokens="4" value="4" @if(!empty($news)) @if($news->status == '4') selected='true' @endif @endif>Published</option>
                                </select>  
                                  @if(!empty($errors->first('news_status')))
                                  <span class="help-block">{{ $errors->first('news_status') }}</span>
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