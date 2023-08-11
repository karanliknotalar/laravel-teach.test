@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Sliders'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("slider.create")'>

        <x-slot name="ths">
            <th>Resim</th>
            <th>Başlık</th>
            <th>İçerik</th>
            <th>Url</th>
            <th>Durum</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($sliders as $slider)
                @php
                    $sliderId = encrypt($slider->id);
                @endphp
                <tr itemid="{{ $sliderId }}">
                    <td>
                        <img src="{{ asset($slider->image) }}" alt="image"
                             class="img-fluid avatar-lg">
                    </td>
                    <td>{{ $slider->name }}</td>
                    <td>{!! $slider->content ?? "" !!}</td>
                    <td>{{ $slider->shop_url ?? "" }}</td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$sliderId"
                            :status="$slider->status"
                            :select-class="'sliderStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("slider.edit", ["slider" => $sliderId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Slider düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Slider sil'"
                                :class="'btn btn-danger p-1 btnDelete mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $slider->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[0,4,5]'"
        :order-index="'6'"
        :director="'desc'"/>

    <x-admin.jquery-toast.jquery-toast-js
    :use-toast-status="true"
    :select-checkbox-query="'.sliderStatus'"
    :update-route='route("slider.update-status", ["id" => ":id"])'
    :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("slider.destroy", ["slider" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>
@endsection
