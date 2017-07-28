@extends('layouts.master')

@section('content')
    
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
        <input type="text" name="niceness"/>
        <button type="submit">Do a nice action!</button>
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
    </div>

@endsection