@extends('layouts.master')

@section('content')
<div class="container posts-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('layouts.errors')
            @include('layouts.status')
            <div class="panel panel-success">
                <div class="panel-heading">
					@include('layouts.postimage', ['width' => 400])
                	<h4>
                		{{ $post->title }}
                        @if ($post->isUnpublished())
                            <span class="label label-danger">Unpublished</span>
                        @endif
                	</h4>
                    <p>
                    	<strong>Created by: </strong>
                    	{{ $post->user->name }} on 
                    	<em>
                    		{{ $post->created_at->toDayDateTimeString() }}
                    	</em>
                    </p>
                    @can('update', $post)
                            <a class="btn btn-sm btn-primary" href="{{ route('posts.edit', $post) }}">Edit</a> 
                    @endcan
                    @can('delete', $post)
                    		<form style="display:inline" method="POST" action="{{ route('posts.destroy', $post) }}">
                    			{{ csrf_field() }}
                    			{{ method_field('DELETE') }}
                            	<button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>

                    @endcan

                </div>
                <div class="panel-body">
                	<p>
                		{{ $post->content }}
                	</p>
                </div>
            </div>
            <div class="panel panel-info">
            	<div class="panel-heading">
            		<h4>Comments</h4>
            	</div>
            	<div class="panel-body">
                    @forelse($post->comments as $comment)
            			<p>
	        		        <strong>
	        					{{ $comment->user->name }} 
	        					commented
	        					<em>
	        						{{ $comment->created_at->diffForHumans() }}
	        					</em>
	        				</strong>
        				</p>
            			<p>
            				{{ $comment->text }}
            			</p>
                    @empty
                        <p>No Comments posted yet.</p>
                    @endforelse
            	</div>
            </div>
            @can('create', [App\Comment::class, $post])
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Add Comment
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('comments.store', $post) }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea id="text" name="text" class="form-control" required>{{ old('text') }}</textarea>
                            </div>  
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>                
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection

