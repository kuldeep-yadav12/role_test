<form id="blog-filter-form" class="row g-3 mb-4 align-items-center d-flex">
    <input type="hidden" name="tab" id="active-tab-input" value="{{ $activeTab ?? 'all' }}">
    
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

    <a href="{{ route('blog.main_blog.create') }}" class="btn btn-success">+ Add Blog</a>
</form>
