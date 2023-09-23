@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Kargo Bilgileri'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("shipping-company.index")'>

        <x-slot name="ths">
            <th>Kargo Adı</th>
            <th>Takip Url'si</th>
            <th>Durum</th>
            <th>Eylem</th>
        </x-slot>

        <x-slot name="tbody">
            @foreach($shipping_companies as $s_company)
                @php
                    $shipping_company_Id = encrypt($s_company->id);
                @endphp
                <tr itemid="{{ $shipping_company_Id }}">

                    <td>{{ $s_company->name }}</td>
                    <td>
                        <p class="text-wrap w-100">
                            {!! $s_company->tracking_url ?? "" !!}
                        </p>
                    </td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$shipping_company_Id"
                            :status="$s_company->status"
                            :select-class="'shippingCompanyStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("shipping-company.edit", ["shipping_company" => $shipping_company_Id]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Hizmeti düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Hizmeti sil'"
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

    <x-admin.helpers.layout.edit-page-layout
        :model="$shipping_company ?? null"
        :page-title="'Kargo Bilgisi Ekle'"
        :content-class="'col-lg-6'">

        <x-slot name="contents">
            <form
                action="{{ isset($shipping_company) ? route("shipping-company.update", ["shipping_company" => encrypt($shipping_company->id)]) : route("shipping-company.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($shipping_company))
                    @method('PUT')
                @endif

                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$shipping_company->name ?? ''"
                    :title="'Kargo Firma Adı'"/>

                <x-admin.helpers.input-text
                    :name="'tracking_url'"
                    :value="$shipping_company->tracking_url ?? ''"
                    :title="'Kargo Takip Url\'si'"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($shipping_company) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[2, 3]'"
        :order-index="'0'"
        :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("shipping-company.destroy", ["shipping_company" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

    <x-admin.jquery-toast.jquery-toast-js
        :use-toast-status="true"
        :select-checkbox-query="'.shippingCompanyStatus'"
        :update-route='route("shipping-company.update-status", ["id" => ":id"])'
        :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>
@endsection
