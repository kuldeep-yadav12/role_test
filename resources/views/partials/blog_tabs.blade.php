<ul class="nav nav-pills mb-3" id="blog-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-blogs-tab" data-bs-toggle="pill" data-bs-target="#all-blogs" type="button"
            role="tab" aria-controls="all-blogs" aria-selected="true">All Blogs</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="trash-blogs-tab" data-bs-toggle="pill" data-bs-target="#trash-blogs" type="button"
            role="tab" aria-controls="trash-blogs" aria-selected="false">Trash Blogs</button>
    </li>
</ul>

<div class="tab-content" id="blog-tabContent">
    {{-- All Blogs Tab --}}
    <div class="tab-pane fade show active" id="all-blogs" role="tabpanel" aria-labelledby="all-blogs-tab">
        All Blogs
    </div>

    {{-- Trash Blogs Tab --}}
    <div class="tab-pane fade" id="trash-blogs" role="tabpanel" aria-labelledby="trash-blogs-tab">
        Trash Blogs
    </div>
</div>
