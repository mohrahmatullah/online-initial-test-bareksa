@extends('includes.default')
@section('title', 'Topik | Bareksa')
@section('content')
@include('pages_message.notify-msg-success')
<!-- Main Content -->
<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('topik-update', 0)}}" class="btn btn-outline-primary">Create</a>
                    </div>
                    <div class="card-body">
                        <table id="tagTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($post->count() > 0 )
                                @foreach($post as $p)
                                <tr>
                                    <td><a href="{{ route('/') . '?topik=' .  $p->slug }}">{{ $p->name }}</a></td>
                                    <td>{{ $p->created }}</td>
                                    <td>
                                        <a href="{{ route('topik-update', $p->id)}}">Edit</a> | 
                                        <a href="#" onclick="deleted_item( <?= $p->id ?> ,'list_topik');"> Delete </a> | 
                                        <a href="{{ route('/') . '?topik=' .  $p->slug }}"> Lihat Berita By Topik </a>
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