@extends("admin.layout.layout")

@section("css")
    <!-- Flatpickr Timepicker css -->
    <link href="{{ $asset }}vendor/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$coupon ?? null"
        :page-title="'Kupon'">

        <x-slot name="contents">
            <form
                action="{{ isset($coupon) ? route("coupon.update", ["coupon" => encrypt($coupon->id)]) : route("coupon.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($coupon))
                    @method('PUT')
                @endif

                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$coupon->name ?? ''"
                    :title="'Kupon Adı'"/>

                <x-admin.helpers.input-text
                    :name="'price'"
                    :value="$coupon->price ?? ''"
                    :title="'İndirim Tutarı'"/>

                <div class="mb-3">
                    <label class="form-label">Sona Erme Zamanı</label>
                    <input type="text" id="datetime-datepicker" class="form-control" placeholder="Sona Erme Zamanı"
                           name="expired_at" value="{{ $coupon->expired_at ?? '' }}">
                </div>

                <x-admin.helpers.input-checkbox
                    :label-title="'Durum:'"
                    :name="'status'"
                    :checked-status="isset($coupon) && $coupon->status == 1 ? 'checked' : ''"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($coupon) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <!-- Flatpickr Timepicker Plugin js -->
    <script src="{{ $asset }}vendor/flatpickr/flatpickr.min.js"></script>
    <script>
        $("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        })
    </script>
@endsection
