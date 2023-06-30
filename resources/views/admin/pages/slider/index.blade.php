@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>

    <!-- Jquery Toast css -->
    <link href="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">

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
                                :class="'btn btn-danger p-1 btnsil mx-1'">
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

    <!-- Jquery Toast js -->
    <script src="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.js"></script>

    <script>
        <!-- Switch Status on/off js -->
        function showToast(message, icon, timeout) {
            $.toast({
                text: message,
                icon: icon,
                allowToastClose: false,
                hideAfter: timeout,
                position: 'top-right',
            });
        }

        $(".sliderStatus").on("click", function (p) {

            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("slider.update", ["slider" => ":id"]) }}".replace(":id", id);
            const status = $(this).prop("checked") ? 1 : 0;

            $.ajax({
                method: "PUT",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status
                },
                success: function (response) {
                    response.result
                        ? showToast("İşlem başarılı", "success", 1200)
                        : showToast("İşlem başarısız", "error", 1200);
                }
            });
        });
    </script>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnsil'"
        :destroy-route='route("slider.destroy", ["slider" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

@endsection
