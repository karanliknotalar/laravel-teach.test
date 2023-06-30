<div class="row">
    <div class="{{ $titleClass ?? "col-12" }}">
        <div class="page-title-box">
            <h4 class="page-title">{{ isset($model) ? $pageTitle ." Düzenle" : $pageTitle." Ekle" }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="{{ $contentClass ?? "col-lg-7" }}">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="floating-preview">
                        <div class="row">
                            <div class="{{ $contentElementsClass ?? "col-12" }}">
                                @if(count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                        <div
                                            class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                            role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                                @if(session()->has("status"))
                                    <div
                                        class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                        {{ session("status") }}
                                    </div>
                                @endif
                                {{ $contents ?? "" }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($model))
        <div class="{{ $imageMainClass ?? "col-lg-5"}}">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="floating-preview">
                            <div class="row">
                                <div class="{{ $imageElementClass ?? "col-12"}}">
                                    <div class="page-title-box">
                                        <h4 class="page-title">{{ $imageElementTitle ?? "Resim Önizlemesi"}}</h4>
                                        <img class="d-block img-fluid"
                                             src="{{ asset($image) }}"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
