<form action="{{ route('user.list') }}" class="row g-3 mb-4" id="user-filter-form">
    <div class="col">
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request('name') }}">
    </div>
    <div class="col">
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
    </div>
    <div class="col">
        <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ request('phone') }}">
    </div>
    <div class="col">
        <select name="gender" class="form-control">
            <option value="">Gender</option>
            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="col">
        <input type="number" name="age" class="form-control" placeholder="Age" value="{{ request('age') }}">
    </div>
    <div class="col">
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
    </div>
    <div class="col">
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
    </div>
    <div class="col d-flex">
        <button type="submit" class="btn btn-primary ">Filter</button>
        <button type="button" id="reset-button" class="btn btn-secondary mx-2">Reset</button>
        <button class="btn btn-danger bulk-action-btn" data-target=".user-checkbox"
            data-url="{{ route('users.bulkSoftDelete') }}"
            data-confirm="Are you sure you want to delete selected users?">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</form>
