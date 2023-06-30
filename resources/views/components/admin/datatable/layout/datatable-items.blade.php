<div class="row">
    <div class="col-12 float-end">
        <a href="{{ $addNewRoute }}" class="btn btn-success my-2 float-end">Yeni EKle</a>
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
