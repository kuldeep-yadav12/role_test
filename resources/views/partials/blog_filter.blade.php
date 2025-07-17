<form action="{{ route('blog.main_blog.index') }}" method="GET" class="row g-3 mb-4" id="blog-filter-form">
    <div class="col">
        <input type="text" name="title" class="form-control" placeholder="Name" value="{{ request('title') }}">
    </div>
    <div class="col">
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
    </div>
    <div class="col">
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
    </div>
    <div class="col d-flex">
        <button type="submit" class="btn btn-primary mr-3">Filter</button>
        <button type="button" id="reset-button" class="btn btn-secondary">Reset</button>
    </div>
</form>

