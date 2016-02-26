@extends('app')

@section('page-header')
    <h2>Announcements</h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="/">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Announcement</span></li>
        </ol>

        <div class="sidebar-right-toggle"></div>
    </div>
@endsection

@section('content')
    <!-- start: page -->
    <section class="content-with-menu mailbox">
        <div class="content-with-menu-container" data-mailbox data-mailbox-view="email">
            <div class="inner-body mailbox-email">
                <div class="mailbox-email-header mb-lg">
                    <h3 class="mailbox-email-subject m-none text-light">
                        Announcement
                    </h3>
                </div>
                <div class="mailbox-email-container">
                    <div class="mailbox-email-screen">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="announcement-content">
                                    <p>{{$item->description}}</p>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <p class="m-none">
                                    <small>{{$item->created_at}}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection