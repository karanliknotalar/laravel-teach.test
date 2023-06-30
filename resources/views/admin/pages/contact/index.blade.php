@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
@endsection

@section("content")

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
                    <div>
                        <ul class="email-list alert alert-info bg-transparent text-info px-0">
                            @if(isset($contacts) && $contacts->count() > 0)
                                @foreach($contacts as $contact)
                                    <li class="{{ $contact->status == 0 ? "unread" : "" }}">
                                        <div class="email-sender-info">
                                            <div class="float-start m-0 px-2">
                                                <span class="badge
                                                {{ $contact->status == 0 ? "bg-danger" : "bg-success" }}">
                                                    {{ $contact->status == 0 ? "Okunmadı" : "Okundu" }}
                                                </span>
                                            </div>
                                            <a href="{{ route("contact.show", ["contact" => encrypt($contact->id)]) }}"
                                               class="email-title">{{ $contact->firstname . " " . $contact->lastname }}</a>
                                        </div>
                                        <div class="email-content">
                                            <a href="{{ route("contact.show", ["contact" => encrypt($contact->id)]) }}"
                                               class="email-subject">
                                                {{ $contact->subject }}
                                            </a>
                                            <div class="email-date px-2">
                                                {{ date_format($contact->created_at,"H:i:s") }}
                                            </div>
                                        </div>
                                        <div class="email-action-icons">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a class="btnDelete" itemid="{{ encrypt($contact->id) }}">
                                                        <i class="mdi mdi-delete email-action-icons-item"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-7 mt-1">
                            Showing {{ $contacts->firstItem() }} - {{ $contacts->lastItem() }}
                            of {{ $contacts->total() }}
                        </div>
                        <div class="col-5">
                            {!! $contacts->links("pagination::contact") !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-hidden-id="'quilltext'"/>
    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("contact.destroy", ["contact" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).attr("itemid")
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

    <script>
        $("input:checkbox").change(function () {
            $(this).is(":checked") ? $(this).parent().parent().parent().parent().addClass("mail-selected") : $(this).parent().parent().parent().parent().removeClass("mail-selected")
        }), function (e) {
            "use strict";

            function t() {
            }

            t.prototype.init = function () {
                new SimpleMDE({
                    element: document.getElementById("simplemde1"),
                    spellChecker: !1,
                    placeholder: "Write something..",
                    tabSize: 2,
                    status: !1,
                    autosave: {enabled: !1}
                })
            }, e.SimpleMDEEditor = new t, e.SimpleMDEEditor.Constructor = t
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.SimpleMDEEditor.init()
        }();
    </script>
@endsection
