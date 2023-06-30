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
