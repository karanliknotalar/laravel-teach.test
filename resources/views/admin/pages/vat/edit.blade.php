@extends("admin.layout.layout")

@section("css")

@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$vat ?? null"
        :page-title="'KDV Oranı'"
        :content-class="'col-3'">

        <x-slot name="contents">
            <form
                action="{{ isset($vat) ? route("vat.update", ["vat" => encrypt($vat->id)]) : route("vat.store")  }}"
                method="post">
                @csrf
                @if(isset($vat))
                    @method('PUT')
                @endif

                <x-admin.helpers.input-text
                    :name="'VAT'"
                    :value="$vat->VAT ?? ''"
                    :title="'KDV Oranı'"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($vat) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
@endsection
