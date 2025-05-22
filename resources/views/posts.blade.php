@extends('layouts.app')
@section('content')
    <div class="row">
                    @foreach($posts as $index => $post)
                        @if($index === 0 && ($page == 1 || !$page))
                            <div class="col-md-12">
                                <article class="single-blog">
                                    <div class="post-thumb">
                                        <a href="{{ url('single-post/' . $post->slug) }}">
                                            <img src="{{ $post->featured_image ? asset($post->featured_image) : asset('assets/images/default.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <div class="entry-header text-center text-uppercase">
                                            <a href="#" class="post-cat">{{$post->topic->first()->name}}</a>
                                            <h2><a href="{{ url('single-post/' . $post->slug) }}">{{ $post->title }}</a></h2>
                                        </div>
                                        <div class="entry-content">
                                            <p>{{ strip_tags(Str::limit($post->body, 250)) }}</p>
                                        </div>
                                        <div class="continue-reading text-center text-uppercase">
                                            <a href="{{ url('single-post/' . $post->slug) }}">Continue Reading</a>
                                        </div>
                                        <div class="post-meta">
                                            <ul class="pull-left list-inline author-meta">
                                                <li class="author">By <a href="#">{{ $post->user->name }}</a></li>
                                                <li class="date"> On {{ \Carbon\Carbon::parse($post->published_at)->format('F d, Y') }}</li>
                                            </ul>
                                            <ul class="pull-right list-inline social-share">
                                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @else
                            <div class="col-md-12">
                                <article class="single-blog post-list">
                                    <div class="media">
                                        <div class="media-left">
                                            <div class="post-thumb">
                                                <a href="{{ url('single-post/' . $post->slug) }}">
                                                    <img src="{{ $post->featured_image ? asset($post->featured_image) : asset('assets/images/default.jpg') }}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="post-content">
                                                <div class="entry-header text-left text-uppercase">
                                                    <a href="#" class="post-cat">{{$post->topic->first()->name}}</a>
                                                    <h2><a href="{{ url('single-post/' . $post->slug) }}">{{ $post->title }}</a></h2>
                                                </div>
                                                <div class="entry-content">
                                                    <p>{{ strip_tags(Str::limit($post->body, 150)) }}</p>
                                                </div>
                                                <div class="post-meta">
                                                    <ul class="list-inline author-meta">
                                                        <li class="author">By <a href="#">{{ $post->user->name }}</a></li>
                                                        <li class="date"> On {{ \Carbon\Carbon::parse($post->published_at)->format('F d, Y') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endif
                    @endforeach
                        @if ($posts->lastPage() > 1)
                            <div class="col-md-12">
                                <div class="post-pagination clearfix">
                                    <ul class="pagination text-left">
                                        {{-- Previous Page Link --}}
                                        @if ($posts->currentPage() > 1)
                                            <li>
                                                <a href="{{ $posts->previousPageUrl() }}"><i class="fa fa-angle-double-left"></i></a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                            <li class="{{ $posts->currentPage() == $i ? 'active' : '' }}">
                                                <a href="{{ $posts->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($posts->currentPage() < $posts->lastPage())
                                            <li>
                                                <a href="{{ $posts->nextPageUrl() }}"><i class="fa fa-angle-double-right"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif

                </div>
@stop
