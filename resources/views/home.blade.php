@extends('layouts.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="centered">
    @foreach($actions as $action)
    <a href="{{ route('niceaction', ['action'=>lcfirst($action->name)]) }}">{{$action->name}}</a>
    @endforeach

      <br>
      <br>
      @if(count($errors) > 0)
      <div>
        <ul>
        @foreach($errors->all() as $error)
            {{$error}}
        @endforeach
        </ul>
      </div>
      @endif

      <form action="{{route('add_action')}}" method="post">
        <label for="name">Name of Action:</label>
        <input type="text" name="name" id="name"/>
        <label for="niceness">Niceness:</label>
        <input type="text" name="niceness" id="niceness"/>
        <button type="submit" onclick="send(event)">Do a nice action!</button>
        <input type="hidden" value="{{Session::token()}}" name="_token">
      </form>
      <br><br><br>
      <ul>
        @foreach($logged_actions as $logged_action)
        <li>
        {{$logged_action->nice_action->name}}
        @foreach($logged_action->nice_action->categories as $category)
          {{$category->name}}
        @endforeach
        </li>
        @endforeach
      </ul>
      @if($logged_actions->lastPage() > 1)
        @for($i =1; $i<=$logged_actions->lastPage(); $i++)
            <a href="{{ $logged_actions->url($i)}}">{{ $i }}</a>
        @endfor
      @endif
<!-- {!! $logged_actions->links() !!} -->
    </div>
    <script type="text/javascript">
      
      function send(event){
        event.preventDefault();
        $.ajax({
          type:"POST",
          url:"{{ route('add_action')}}"
          data:{name:$("#name").val(), niceness: $('#niceness').val(), _token: "{{Session::token()}}" }

        });
      }
    </script>

@endsection