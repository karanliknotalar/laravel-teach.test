@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'KDV Oranları'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("vat.create")'>

        <x-slot name="ths">
            <th>KDV Oranları</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>

        <x-slot name="tbody">
            @if(isset($vats) and $vats->count() > 0)
                @foreach($vats as $vat)
                    @php
                        $vatId = encrypt($vat->id);
                    @endphp
                    <tr itemid="{{ $vatId }}">
                        <td>KDV Oranı {{ $vat->VAT }}%</td>
                        <td class="table-action">
                            <div class="d-flex">
                                <a class="mx-1"
                                   href="{{ route("vat.edit", ["vat" => $vatId]) }}">
                                    <x-admin.helpers.button
                                        :over-text="true"
                                        :message="'KDV Oranını düzenle'"
                                        :class="'btn btn-primary p-1'">
                                        <x-slot:text>
                                            <i class="mdi mdi-pencil"></i>
                                        </x-slot:text>
                                    </x-admin.helpers.button>
                                </a>
                                @if($vat->id != 1 && $vat->id != 2)
                                    <x-admin.helpers.button
                                        :over-text="true"
                                        :message="'KDV Oranını Sil'"
                                        :class="'btn btn-danger p-1 btnDelete mx-1'">
                                        <x-slot:text>
                                            <i class="mdi mdi-delete"></i>
                                        </x-slot:text>
                                    </x-admin.helpers.button>
                                @endif
                            </div>
                        </td>
                        <td>{{ $vat->created_at }}</td>
                    </tr>
                @endforeach
            @endif
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[1]'"
        :order-index="'0'"
        :director="'asc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("vat.destroy", ["vat" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

@endsection
