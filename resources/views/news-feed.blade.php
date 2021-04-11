@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('/post')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="body" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="image">
                            </div>
                            <div class="btn-toolbar justify-content-end">
                                <div class="btn-group">
                                    <button class="btn btn-primary" type="submit">Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(!empty($posts))
                    @foreach($posts as $post)
                        {{--posts ไม่เป็นตัวแปรต้องมี $ ข้างหน้า
                         $posts คือ ตัวแปรที่มีค่ามากกว่า 1 ค่าอาจจะเป็น Array หรือตัวแปรชนิดอื่นๆที่มีการเก็บค่าหลายค่าเอาไว้
                         $post เฉยๆไม่มี s คือ ตัวแปรที่ทำหน้าที่วิ่งส่ง วิ่งใช้ทีละ 1 ค่า จาก $posts วนไปเรื่อยๆ ตามจำนวนที่มีอยู่ใน $posts
                         ดังนั้น ถ้าไม่มี s คือ ตัวแปรที่ใช้วิ่งวน คล้ายกับตัวแปร i ใน for ของภาษาซี เช่น
                         for(int i=0;i<=$posts;i++){count<<i}
                         ค่าเริ่มต้น ; update ; เงื่อนไข
                         Grammar ของการเขียนโค้ด
                         dynamic programming คือ มีการเคลื่อนไหว เปลี่ยนแปลงตามเงื่อนไขต่าง
                         static คือ แก้แล้วแก้เลย ไม่เปลี่ยนแปลง เช่น html css--}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                            <a href="{{ url('/profile/'.$post->user->id) }}">
                                                <img src="{{$post->user->image ? $post->user->image:'https://picsum.photos/58/58'}}" width="45" class="rounded-circle">
                                            </a>
                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">{{$post->user->name}}</div>
                                            <div class="text-muted">
                                                <i class="fa fa-clock-o"></i> {{$post->created_at->diffForhumans()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{$post->body}}
                                </p>
                                <p class="text-center">
                                    <img src="{{$post->image}}" class="img-fluid">
                                </p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ url('/post/like/'.$post->id) }}" method="post">
                                            @csrf
                                            @if(!$post->likes->contains('user_id',\Auth::user()->id))
                                                <button class="btn btn-outline-primary" type="submit"><i class="far fa-thumbs"></i>Like</button>
                                            @else
                                                <button class="btn btn-primary" type="submit"><i class="far fa-thumbs"></i>Like</button>

                                            @endif
                                        </form>
                                        <span class="text-muted">&nbsp;{{$post->likes->count()}}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">comments {{$post->comments->count()}}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <form action="{{'/post/comment/'.$post->id}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="body" row="3" class="form-control"></textarea>
                                        </div>
                                        <div class="btn-toolbar justify-content-end">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary">comment</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(!$post->comments->isEmpty())
                                        <ul class="list-unstyled">
                                            @foreach($post->comments as $comment)
                                                <li class="media p-2 mt-2">
                                                    <a href="{{url('/profile/'.$comment->user->id)}}">
                                                        <img src="{{$comment->user->image ? $comment->user->image:'https://picsum.photos/58/58'}}" width="30" class="rounded-circle mr-3">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="h6 m-0">{{$comment->user->name}}</div>
                                                        {{$comment->body}}
                                                        <div class="text-muted">
                                                            <i class="fa fa-clock-o"></i> {{$comment->created_at->diffForhumans()}}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- end col-md-6 -->
        </div>
    </div>
@endsection
