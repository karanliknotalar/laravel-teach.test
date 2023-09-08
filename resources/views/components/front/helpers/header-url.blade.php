<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ $mainUrl }}">{{ $mainUrlName}}</a>
                @foreach (Helper::createBreadCrumb($mainUrl, "-") as $breadcrumb)
                    <span class="mx-2 mb-0">/</span>
                    <strong class="text-black">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    </strong>
                @endforeach
            </div>
        </div>
    </div>
</div>
