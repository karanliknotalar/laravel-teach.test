@extends("admin.layout.layout")

@section("css")
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$shippingInfo ?? null"
        :page-title="'Kargo Bilgisi'"
        :content-class="'col-6'">

        <x-slot name="contents">
            <form
                action="{{ isset($shippingInfo) ? route("order.update", ["order" => encrypt($shippingInfo->id)]) : route("order.store")  }}"
                method="post">
                @csrf
                @if(isset($shippingInfo))
                    @method('PUT')
                @endif
                <input type="hidden" name="invoice_id" value="{{ encrypt($invoice->id) }}">
                <x-admin.helpers.input-text
                    :name="'tracking_number'"
                    :value="$shippingInfo->tracking_number ?? ''"
                    :title="'Takip Numarası'"/>

                <div class="form-floating mb-3">
                    <select class="form-select"
                            aria-label="Kargo Şirketi Seçin" name="shipping_companies_id">
                        @if(isset($shippingCompanies))
                            @foreach($shippingCompanies as $shippingCompany)
                                <option
                                    value="{{ $shippingCompany->id }}"
                                    {{ (isset($shippingInfo) and $shippingInfo->shipping_companies_id == $shippingCompany->id) ? "selected" : "" }}>
                                    {{ $shippingCompany->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label for="mainCategorySelect">Kargo Şirketi Seçin</label>
                </div>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($shippingInfo) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
@endsection
