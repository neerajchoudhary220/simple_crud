<div class="d-flex justify-content-center">
    <a href="{{ route('crud.details',$d->id) }}" class="btn btn-info text-white mr-2">View</a>
    <a href="{{ route('crud.edit',$d->id) }}" class="btn btn-warning text-white mr-2">Edit</a>
    <button class="btn btn-danger text-white dltBtn" value="{{ route('crud.delete',$d->id) }}">Delete</button>
</div>