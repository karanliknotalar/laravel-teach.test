<div class="row">
    <div class="col-12 float-end">

        @if(isset($addNewRoute))
            <a href="{{ $addNewRoute }}" class="btn btn-success my-2 float-end">Yeni EKle</a>
        @endif
        @if(isset($editAllRoute))
            <a href="{{ $editAllRoute }}" class="btn btn-primary my-2 float-end mx-2">Düzenle</a>
        @endif
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="items-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        {{ $ths }}
                    </tr>
                    </thead>
                    <tbody>
                    {{ $tbody }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
