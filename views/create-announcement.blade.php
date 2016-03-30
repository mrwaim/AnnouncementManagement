@extends('app')

@section('page-header')
    @include('elements.page-header', ['section_title' => 'Announcements', 'page_title' => 'Compose'])
@endsection


@section('content')
    <!-- start: page -->
    <section class="panel">
        @include('elements.error-message-partial')

        <form class="form-horizontal form-bordered form-bordered" method="POST"
              action="{{ url('/announcement-management/create') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="delivery_mode" value="SMS">
            @if (count($roles) == 1)
                <input type="hidden" name='role_id' value='{{$roles[0]->id}}'>
            @else
                <div class="form-group form-group-invisible">
                    <label for="to" class="control-label-invisible">Target Role</label>

                    <div class="col-sm-offset-2 col-sm-9 col-md-offset-1 col-md-10">
                        <select name='role_id'>
                            @foreach ($roles as $item)
                                <option value='{{$item->id}}'>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            Enter your announcement message below:
            <br>
            <br>

            <div class="form-group form-group-invisible">
                <label for="description" class="control-label-invisible">Message</label>

                <div class="col-sm-offset-3 col-sm-7 col-md-offset-2 col-md-10">
                    <div class="compose">
                        <textarea class="form-control" maxlength="140" data-plugin-maxlength rows="4" name="description"
                                  value="{{ old('description') }}"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 col-md-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"> Send</button>
                    </div>
                </div>
            </div>

            <div>Sms Balance: {{$sms_balance}}</div>
        </form>
    </section>
    <!-- end: page -->

@endsection