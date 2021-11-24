@extends('layouts.backend')

@section('title')
    @lang('teams.team_management')
@endsection

@section('subTitle')
    @lang('teams.team_management_description')
@endsection

@section('buttons')
    @include('partials.forms.button',[
       'title' => __('teams.create_team'),
       'url' => route('teams.create'),
       'color' => 'indigo',
       'icon' => '',
       'size' => 1,
       'extraClasses' => 'mb-4',
       'kind' => 'primary',
       'target' => '_self',
   ])
@endsection

@section('content')

    <form method="POST" action="{{ route('permissions.store') }}">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="">
                @csrf
                @include('partials.messages')

                <ul class="list-unstyled">
                    @foreach($teams as $team)
                        <li class="mb-5">
                            <div class="md:grid md:grid-cols-6 md:gap-6">
                                <div class="md:col-span-3">
                                    <h4 class="text-xl">{{$team->name}}</h4>
                                </div>
                                <div class="md:col-span-3">
                                    {{--<a class="float-right" href="{{ route('teams.edit',$team->id) }}">{{ __('general.edit') }}</a>--}}
                                    @include('partials.forms.button',[
                                        'title' => __('general.edit'),
                                        'url' => route('teams.edit',$team->id),
                                        'color' => 'indigo',
                                        'icon' => '',
                                        'size' => 1,
                                        'extraClasses' => 'mb-4 float-right',
                                        'kind' => 'primary',
                                        'target' => '_self',
                                    ])
                                </div>
                            </div>

                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="w-2/8 pb-3">{{ __('teams.rule_description') }}</th>
                                        <th class="w-1/8 text-center pb-3">{{ __('teams.permission_properties.view') }}</th>
                                        <th class="w-1/8 text-center pb-3">{{ __('teams.permission_properties.create') }}</th>
                                        <th class="w-1/8 text-center pb-3">{{ __('teams.permission_properties.edit') }}</th>
                                        <th class="w-1/8 text-center pb-3">{{ __('teams.permission_properties.delete') }}</th>
                                        <th class="w-1/8 text-center pb-3">{{ __('teams.permission_properties.approve') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allPermissions as $rule => $properties)
                                        <tr>
                                            @php ($teamName = str_replace(' ', '_', $team->name)) @endphp

                                            <td class="py-1">
                                                {{ucfirst(str_replace('_', ' ', $rule))}}
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('view', $properties))
                                                    @php
                                                        $checked = $team->hasPermissionTo($rule.".view") ? "checked" : "";
                                                    @endphp
                                                    @include('partials.forms.checkbox', [
                                                       'label' => '',
                                                       'name' => "permissions[".$teamName."][".$rule.".view]",
                                                       'size' => 'medium',
                                                       'checked' => $checked,
                                                       'required' => false,
                                                   ])
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('create', $properties))

                                                    @php
                                                        $checked = $team->hasPermissionTo($rule.".create") ? "checked" : "";
                                                    @endphp
                                                    @include('partials.forms.checkbox', [
                                                       'label' => '',
                                                       'name' => "permissions[".$teamName."][".$rule.".create]",
                                                       'size' => 'medium',
                                                       'checked' => $checked,
                                                       'required' => false,
                                                   ])
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('edit', $properties))
                                                    @php
                                                        $checked = $team->hasPermissionTo($rule.".edit") ? "checked" : "";
                                                    @endphp
                                                    @include('partials.forms.checkbox', [
                                                       'label' => '',
                                                       'name' => "permissions[".$teamName."][".$rule.".edit]",
                                                       'size' => 'medium',
                                                       'checked' => $checked,
                                                       'required' => false,
                                                   ])

                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('delete', $properties))
                                                    @php
                                                        $checked = $team->hasPermissionTo($rule.".delete") ? "checked" : "";
                                                    @endphp
                                                    @include('partials.forms.checkbox', [
                                                       'label' => '',
                                                       'name' => "permissions[".$teamName."][".$rule.".delete]",
                                                       'size' => 'medium',
                                                       'checked' => $checked,
                                                       'required' => false,
                                                   ])

                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array('approve', $properties))
                                                    @php
                                                        $checked = $team->hasPermissionTo($rule.".approve") ? "checked" : "";
                                                    @endphp
                                                    @include('partials.forms.checkbox', [
                                                       'label' => '',
                                                       'name' => "permissions[".$teamName."][".$rule.".approve]",
                                                       'size' => 'medium',
                                                       'checked' => $checked,
                                                       'required' => false,
                                                   ])

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </li>
                    @endforeach
                </ul>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('teams.save_permissions') }}
                    </button>
                </div>


            </div>
        </div>
    </form>

@endsection

