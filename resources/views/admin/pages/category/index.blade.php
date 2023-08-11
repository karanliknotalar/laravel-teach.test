@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>

@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Categoriler'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("category.create")'>

        <x-slot name="ths">
            <th>Resim</th>
            <th>Başlık</th>
            <th>Açıklama</th>
            <th>Kategori Türü</th>
            <th>Durum</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $category)
                @php
                    $categoryId = encrypt($category->id);
                    $base_categry = $category->base_category == null
                @endphp
                <tr itemid="{{ $categoryId }}" class="{{ $base_categry ? "alert alert-success" : "" }}">
                    <td>
                        <img src="{{ asset($category->image) }}" alt="image"
                             class="img-fluid avatar-lg">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{!! $category->description ?? "" !!}</td>
                    <td>{{ $base_categry ? "Ana Kategori" : "Alt Kategori" }}</td>
                    <td class="">
                        <x-admin.helpers.datatable-checkbox
                            :id="$categoryId"
                            :status="$category->status"
                            :select-class="'categoryStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("category.edit", ["category" => $categoryId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Kategoriyi düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Kategoriyi sil'"
                                :class="'btn btn-danger p-1 btnDelete mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $category->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[0,4,5]'"
        :order-index="'3'"
        :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("category.destroy", ["category" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

    <x-admin.jquery-toast.jquery-toast-js
        :use-toast-status="true"
        :select-checkbox-query="'.categoryStatus'"
        :update-route='route("category.update-status", ["id" => ":id"])'
        :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>
@endsection
