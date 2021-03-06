<!-- First Name | first_name -->
<div class="form-group col-md-3">
    <label>First Name</label>
    <input type="text" class="form-control first_name @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $seller->first_name ?? '') }}">

    @error('first_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Last Name | last_name -->
<div class="form-group col-md-3">
    <label>Last Name</label>
    <input type="text" class="form-control last_name @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $seller->last_name ?? '') }}">

    @error('last_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Profile Picture | profile_picture -->
<div class="form-group col-md-3">
    <label for="">Profile Picture</label>
    <input type="file" name="profile_picture" class="form-control profile_picture @error('profile_picture') is-invalid @enderror" value="{{ old('profile_picture', $seller->profile_picture ?? '') }}" onchange="showPreview(this, '.preview_profile_picture')">

    @error('profile_picture')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Preview | preview_profile_picture -->
<div class="form-group col-md-3">
    <label for="">Preview</label>
    <img src="{{isset($seller) && $seller->profile_picture ? (asset('storage/img/sellers') . '/' . $seller->profile_picture) : asset('storage/img/noimg.jpg')}}" class="preview_profile_picture form-control mb-5" style="height:65%;">
</div>

<!-- Email | email -->
<div class="form-group col-md-3">
    <label>Email</label>
    <input type="email" class="form-control email @error('email') is-invalid @enderror" name="email" value="{{ old('email', $seller->email ?? '') }}">

    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Phone | phone -->
<div class="form-group col-md-3">
    <label>Phone (+92)</label>
    <input type="text" class="form-control phone @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $seller->phone ?? '') }}" placeholder="30x xxxxxxx">

    @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Password | password -->
<div class="form-group col-md-3">
    <label>Password</label>
    <input type="password" class="form-control password @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Confirm Password | password_confirmation -->
<div class="form-group col-md-3">
    <label>Confirm Password</label>
    <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
</div>

<!-- Company Name | company_name -->
<div class="form-group col-md-3">
    <label>Company Name</label>
    <input type="text" class="form-control company_name @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $seller->company_name ?? '') }}">

    @error('company_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Company Address | company_address -->
<div class="form-group col-md-3">
    <label>Company Address</label>
    <input type="text" class="form-control company_address @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address', $seller->company_address ?? '') }}">

    @error('company_address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Company Logo | company_logo -->
<div class="form-group col-md-3">
    <label for="">Company Logo</label>
    <input type="file" class="form-control company_logo @error('company_logo') is-invalid @enderror" name="company_logo" value="{{ old('company_logo', $seller->company_logo ?? '') }}" onchange="showPreview(this, '.preview_company_logo')">

    @error('company_logo')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Preview | preview_company_logo -->
<div class="form-group col-md-3">
    <label for="">Preview</label>
    <img src="{{isset($seller) && $seller->company_logo ? (asset('storage/img/companies') . '/' . $seller->company_logo) : asset('storage/img/noimg.jpg')}}" class="preview_company_logo form-control mb-5" style="height:65%;">
</div>

<!-- Account Status | account_status -->
<div class="form-group col-md-6">
    <label for="">Account Status</label>
    <select class="form-control account_status @error('account_status') is-invalid @enderror" name="account_status" value="{{ old('account_status', $seller->account_status ?? '') }}">
        <option value="0" {!!old('account_status', $seller->account_status ?? '') == '0' ? 'selected' : ''!!}>Inactive</option>
        <option value="1" {!!old('account_status', $seller->account_status ?? '') == '1' ? 'selected' : ''!!}>Active</option>
    </select>

    @error('account_status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<!-- Approval Status | is_approved -->
<div class="form-group col-md-6">
    <label for="">Approval Status</label>
    <select class="form-control is_approved @error('is_approved') is-invalid @enderror" name="is_approved" value="{{ old('is_approved', $seller->is_approved ?? '') }}">
        <option value="" {!!old('is_approved', $seller->is_approved ?? '') == NULL ? 'selected' : ''!!}>Pending Approval</option>
        <option value="0" {!!old('is_approved', $seller->is_approved ?? '') == '0' ? 'selected' : ''!!}>Rejected</option>
        <option value="1" {!!old('is_approved', $seller->is_approved ?? '') == '1' ? 'selected' : ''!!}>Approved</option>
    </select>

    @error('is_approved')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>