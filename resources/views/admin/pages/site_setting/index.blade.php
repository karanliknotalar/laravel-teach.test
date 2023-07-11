@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Site Ayarları'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("site-settings.create")'>

        <x-slot name="ths">
            <th>Anahtar (Key)</th>
            <th>Değer (Value)</th>
            <th>Türü (Type)</th>
            <th>Eylem</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($site_settings as $setting)
                @php
                    $settingId = encrypt($setting->id);
                @endphp
                <tr itemid="{{ $settingId }}">
                    <td>{{ $setting->name }}</td>
                    <td>
                        @if($setting->type == "image")
                            <img src="{{ asset($setting->content) }}" alt="image"
                                 class="img-fluid avatar-lg">
                        @else
                            {!! $setting->content ?? "" !!}
                        @endif
                    </td>
                    <td>{{ $setting->type ?? "" }}</td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("site-settings.edit", ["site_setting" => $settingId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Bu ayarı düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Bu ayarı sil'"
                                :class="'btn btn-danger p-1 btnDelete mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[3]'"
        :order-index="'0'"
        :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("site-settings.destroy", ["site_setting" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>
@endsection
