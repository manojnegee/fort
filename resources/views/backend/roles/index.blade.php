{{-- Master Layout --}}
@extends('rinvex/fort::backend/common.layout')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('rinvex/fort::forms.common.roles') }}
@stop

{{-- Main Content --}}
@section('content')

    <style>
        td {
            vertical-align: middle !important;
        }
    </style>

    <div class="container">

        @include('rinvex/fort::frontend/alerts.success')
        @include('rinvex/fort::frontend/alerts.warning')
        @include('rinvex/fort::frontend/alerts.error')
        @include('rinvex/fort::backend/common.confirm-modal', ['type' => 'role'])

        <section class="panel panel-default">

            {{-- Heading --}}
            <header class="panel-heading">
                <h4>
                    {{ trans('rinvex/fort::forms.common.roles') }}
                    @can('create-roles')
                        <span class="pull-right" style="margin-top: -7px">
                            <a href="{{ route('rinvex.fort.backend.roles.create') }}" class="btn btn-default"><i class="fa fa-plus"></i></a>
                        </span>
                    @endcan
                </h4>
            </header>

            {{-- Data --}}
            <div class="panel-body">

                <div class="table-responsive">

                    <table class="table table-hover" style="margin-bottom: 0">

                        <thead>
                            <tr>
                                <th style="width: 30%">{{ trans('rinvex/fort::forms.common.name') }}</th>
                                <th style="width: 40%">{{ trans('rinvex/fort::forms.common.description') }}</th>
                                <th style="width: 15%">{{ trans('rinvex/fort::forms.common.created_at') }}</th>
                                <th style="width: 15%">{{ trans('rinvex/fort::forms.common.updated_at') }}</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($roles as $role)

                                <tr>
                                    <td>
                                        @can('update-roles', $role) <a href="{{ route('rinvex.fort.backend.roles.edit', ['role' => $role]) }}"> @endcan
                                            <strong>{{ $role->name }}</strong>
                                            <div class="small ">{{ $role->slug }}</div>
                                        @can('update-roles', $role) </a> @endcan
                                    </td>

                                    <td>
                                        {{ $role->description }}
                                    </td>

                                    <td class="small">
                                        @if($role->created_at)
                                            <div>
                                                {{ trans('rinvex/fort::forms.common.created_at') }}: <time datetime="{{ $role->created_at }}">{{ $role->created_at->format('Y-m-d') }}</time>
                                            </div>
                                        @endif
                                        @if($role->updated_at)
                                            <div>
                                                {{ trans('rinvex/fort::forms.common.updated_at') }}: <time datetime="{{ $role->updated_at }}">{{ $role->updated_at->format('Y-m-d') }}</time>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        @can('update-roles', $role) <a href="{{ route('rinvex.fort.backend.roles.edit', ['role' => $role]) }}" class="btn btn-xs btn-default"><i class="fa fa-pencil text-primary"></i></a> @endcan
                                        @can('delete-roles', $role) <a href="#" class="btn btn-xs btn-default" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('rinvex.fort.backend.roles.delete', ['role' => $role]) }}" data-item-name="{{ $role->slug }}"><i class="fa fa-trash-o text-danger"></i></a> @endcan
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            @include('rinvex/fort::backend/common.pagination', ['resource' => $roles])

        </section>

    </div>

@endsection
