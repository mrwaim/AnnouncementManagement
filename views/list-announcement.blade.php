@extends('app')

@section('page-header')
    @include('elements.page-header', ['section_title' => 'Announcements', 'page_title' => 'Announcements'])
@endsection

@section('content')

    <!-- start: page -->
    <section class="content-with-menu mailbox">
        <div class="content-with-menu-container" data-mailbox data-mailbox-view="folder">


            <div class="inner-body mailbox-folder">
                <!-- START: .mailbox-header -->
                <header class="mailbox-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="mailbox-title text-light m-none">
                                <a id="mailboxToggleSidebar" class="sidebar-toggle-btn trigger-toggle-sidebar">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line line-angle1"></span>
                                    <span class="line line-angle2"></span>
                                </a>

                                Announcements
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="search">
                                @if($auth->admin)
                                    <a href="/announcement-management/create"
                                       class="btn btn-block btn-primary btn-md pt-sm pb-sm text-md compose-btn">
                                        <i class="fa fa-envelope mr-xs"></i>
                                        Compose
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>
                <!-- END: .mailbox-header -->

                <!-- END: .mailbox-actions -->

                <div id="mailbox-email-list" class="mailbox-email-list">
                    <div class="nano">
                        <div class="nano-content">
                            @if(Session::has('success_message'))
                                <div class="alert alert-success">{{Session::get('success_message')}}</div>
                            @endif
                            <ul id="" class="list-unstyled">
                                @foreach($list as $item)
                                    <li class="unread">
                                        <a href="/announcement-management/view/{{$item->id}}">
                                            <div class="col-sender">
                                                <div class="checkbox-custom checkbox-text-primary ib">
                                                </div>
                                                <p class="m-none ib">{{$item->user->name}}</p>
                                            </div>
                                            <div class="col-mail">
                                                <p class="m-none mail-content">
                                                    <span class="subject">{{$item->description}}</span>
                                                </p>

                                                <p class="m-none mail-date" id="date">{{$item->created_at}}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
