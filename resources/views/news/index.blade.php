@extends('includes.default')
@section('title', 'News | Bareksa')
@section('content')
@include('pages_message.notify-msg-success')
<!-- Main Content -->
<div class="row mx-3">
  <div class="col-12">
    <form class="card" action="{{ route('/') }}" method="GET" autocomplete="off">
      <div class="form-group col-xs-4 col-sm-4 col-md-3 col-lg-3">
          <br>
          <div class="row form-group">
              <div class="col col-md-3"><label for="topik" class=" form-control-label">Topik</label></div>
              <div class="col-12 col-md-9">
                  <select name="topik" id="select" class="form-control">
                      <option data-tokens="all" value="all">Semua</option>
                      @foreach($topik as $cat)
                        @php
                          $sel = '';
                          if(isset($result['topik']) && $cat->slug == $result['topik'])
                            $sel = "selected='true'";
                        @endphp
                        <option data-tokens="{{ $cat->id }}" value="{{ $cat->slug }}" {{ $sel }}>{{ $cat->name }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
      </div>

      <div class="form-group col-xs-4 col-sm-4 col-md-3 col-lg-3">
        <div class="row form-group">
            <div class="col col-md-3"><label for="sts" class=" form-control-label">Status</label></div>
            <div class="col-12 col-md-9">
                <select name="sts" id="select" class="form-control">
                    <option data-tokens="all" value="all" @if(isset($result['sts']) && $result['sts'] == 'all') selected='true' @endif>Semua</option>
                    <option data-tokens="1" value="1" @if(isset($result['sts']) && $result['sts'] == '1') selected='true' @endif>Draft</option>
                    <option data-tokens="2" value="2" @if(isset($result['sts']) && $result['sts'] == '2') selected='true' @endif>Editor</option>
                    <option data-tokens="3" value="3" @if(isset($result['sts']) && $result['sts'] == '3') selected='true' @endif>Schedule</option>
                    <option data-tokens="4" value="4" @if(isset($result['sts']) && $result['sts'] == '4') selected='true' @endif>Published</option>
                </select>
            </div>
        </div>

      </div>


      <!-- start button -->
      <div class="form-group col-xs-4 col-sm-4 col-md-3 col-lg-3">
        <label for="sbt">&nbsp;</label>
        <div class="input-group-btn">
          <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        
      </div>
    </form>
  </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('news-update', 0)}}" class="btn btn-outline-primary">Create</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="newsTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($post->count() > 0 )
                                @foreach($post as $p)
                                    @php
                                        $fullname = '';
                                        $pt = \App\PostTopik::where('id', $p->post_topik)->first();
                                      @endphp
                                <tr>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ $pt->name }}</td>
                                    @if($p->status == 1)
                                    <td>Draft</td>
                                    @elseif($p->status == 2)
                                    <td>Editor</td>
                                    @elseif($p->status == 3)
                                    <td>Schedule</td>
                                    @else
                                    <td>Published</td>
                                    @endif
                                    <td>{{ $p->created }}</td>
                                    <td>
                                      <a href="{{ route('news-update', $p->id)}}"> Edit </a> | 
                                      <a href="#" onclick="deleted_item( <?= $p->id ?> ,'list_news');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->
<!-- /Main Content -->
@endsection