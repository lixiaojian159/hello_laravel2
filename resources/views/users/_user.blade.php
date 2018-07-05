<li>
    <img src="{{ $v->gravatar() }}" alt="{{ $v->name }}" class="gravatar"/>
    <a href="{{ route('users.show',$v->id) }}" class="username">{{ $v->name }}</a>
	@can('destroy',$v)
	<form action="{{ route('users.destroy',$v->id) }}" method="post">
	   {{ csrf_field() }}
	   {{method_field('DELETE')  }}
	   <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
	</form>
	@endcan
</li>