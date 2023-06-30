@extends("admin.layout.layout")

@section("css")
    <x-admin.sweet-alert2.sweet-alert2-css/>
@endsection

@section("content")

    @if(!isset($contact->id))
        {{ exit() }}
    @endif
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">İletişim</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-3">
                        <h5 class="font-18">{{ $contact->subject }}</h5>

                        <hr/>
                        <div class="d-flex mb-3 mt-1">
                            <div class="w-100 overflow-hidden">
                                <small class="float-end">{{ $contact->created_at }}</small>
                                <h6 class="m-0 font-14">{{ $contact->firstname . " " . $contact->lastname }}</h6>
                                <small class="text-muted">Mail: {{ $contact->email }}</small><br>
                                <small class="text-muted">IP: {{ $contact->ip }}</small>
                            </div>
                        </div>

                        {!! $contact->message !!}

                        <hr/>
                        <div class="mt-3">
                            <a href="{{ route("contact.index") }}" class="btn btn-secondary me-2"><i class="mdi mdi-arrow-left-drop-circle me-1"></i> Geri Dön</a>
                            <a itemid="{{ encrypt($contact->id) }}" class="btn btn-danger me-2 btnsil"><i class="mdi mdi-delete me-1"></i> Sil</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

@endsection

@section("js")
    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnsil'"
        :destroy-route='route("contact.destroy", ["contact" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).attr("itemid")
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>
@endsection
