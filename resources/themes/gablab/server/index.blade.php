
@extends('layouts.master')

@section('title')
    {{ trans('server.index.title', [ 'name' => $server->name]) }}
@endsection

@section('scripts')
    @parent
    {!! Theme::css('vendor/jquery/jquery.terminal.min.css') !!}

    <style>#terminal {height: 400px !important;}</style>
@endsection


@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Servers</a></li>
            <li class="breadcrumb-item active">{{ $server->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-md-8">
            <div id="terminal" style="heigth: 500px;" class="mb-3"></div>
            <div class="text-center mb-3">
                @can('power-start', $server)<button class="btn btn-success disabled" data-attr="power" data-action="start">Start</button>@endcan
                @can('power-restart', $server)<button class="btn btn-primary disabled" data-attr="power" data-action="restart">Restart</button>@endcan
                @can('power-stop', $server)<button class="btn btn-danger disabled" data-attr="power" data-action="stop">Stop</button>@endcan
                @can('power-kill', $server)<button class="btn btn-danger disabled" data-attr="power" data-action="kill">Kill</button>@endcan
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-body">
                <div class="row">
                    <span class="col-12 col-sm-4">Address:</span>
                    <div class="col-12 col-sm-8 text-right">
                        <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                    </div>
                </div>
                <div class="row">
                    <span class="col-12 col-sm-6">CPU Usage:</span>
                    <div class="col-12 col-sm-6 text-right">
                        <span data-action="cpu" data-cpumax="{{ $server->cpu }}">--</span> %
                    </div>
                </div>
                <div class="row">
                    <span class="col-12 col-sm-6">RAM Usage:</span>
                    <div class="col-12 col-sm-6 text-right">
                        <span data-action="memory">--</span> / {{ $server->memory === 0 ? '∞' : $server->memory }} MB
                    </div>
                </div>
                @can('access-sftp', $server)
                    <div class="row">
                        <span class="col-12 col-sm-3">FTP IP:</span>
                        <div class="col-12 col-sm-9 text-right">
                            <code>sftp://{{ $node->fqdn }}:{{ $node->daemonSFTP }}</code>
                        </div>
                    </div>
                    <div class="row">
                        <span class="col-12 col-sm-6">FTP Username:</span>
                        <div class="col-12 col-sm-6 text-right">
                            <code>{{ auth()->user()->username }}.{{ $server->uuidShort }}</code>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/ansi/ansi_up.js') !!}
    {!! Theme::js('vendor/jquery/jquery.terminal.min.js') !!}
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('js/frontend/console.js') !!}
    @if($server->nest->name === 'Minecraft')
        {!! Theme::js('js/plugins/minecraft/eula.js') !!}
    @endif
@endsection
