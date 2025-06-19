<div class="row">
    {{-- Field Title --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" id="title" name="title"
                class="form-control form-control-sm @error('title') is-invalid @enderror"
                value="{{ old('title') !== null ? old('title') : $menu->title ?? '' }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Field Parent Menu --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="parent_id" class="form-label">Parent Menu</label>
            <select name="parent_id" id="parent_id"
                class="form-control form-control-sm @error('parent_id') is-invalid @enderror">
                <option value="">-- Tidak ada Parent --</option>
                @foreach ($parentMenus as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->title }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Field Route --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="route" class="form-label">Route</label>
            <input type="text" id="route" name="route"
                class="form-control form-control-sm @error('route') is-invalid @enderror"
                value="{{ old('route', $menu->route ?? '') }}">
            @error('route')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Field Icon --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" id="icon" name="icon"
                class="form-control form-control-sm @error('icon') is-invalid @enderror"
                value="{{ old('icon', $menu->icon ?? '') }}">
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Field Order --}}
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="order" class="form-label">Order <span class="text-danger">*</span></label>
            <input type="text" id="order" name="order"
                class="form-control form-control-sm @error('order') is-invalid @enderror"
                value="{{ old('order', $menu->order ?? '') }}">
            @error('order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
