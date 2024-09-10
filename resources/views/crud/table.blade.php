<div class="card mt-3">
    <div class="card-header d-flex justify-content-around">
        <h5 class="m-auto">Simple Crud List</h5>
      
        <a href="{{ route('crud.add') }}"><button class="btn btn-primary">Add New Entery</button></a>

    </div>

    <div class="card-body mt-3">
        <table class="table table-striped table-hover w-100" id="dt_tbl">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>