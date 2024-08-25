@extends ('layout')
@section('content')
    <h1>create property</h1>
    <div class="container mt-5">
        <form action="{{ route('property.create') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping">Name</span>
                <input type="text" class="form-control" name='name' placeholder="Property Name" aria-label="Username"
                    aria-describedby="addon-wrapping" required>
            </div>
            @error('name')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Images</span>
                <input type="file" class="form-control" name='images[]' multiple placeholder="Category Name"
                    aria-label="Username" aria-describedby="addon-wrapping" required>
            </div>
            @error('images')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="description">Description</span>
                <textarea class="form-control" placeholder="Leave a Description here" required name="description" id="floatingTextarea2"
                    style="height: 100px"></textarea>
            </div>
            @error('description')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Funded Date</span>
                <input type="date" class="form-control" name='funded_date' required placeholder="Funded Date"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('funded_date')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Purchase Price</span>
                <input type="number" class="form-control" name='purchase_price' required placeholder="Purchase Price"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('purchase_price')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Funder Count</span>
                <input type="number" class="form-control" name='funder_count' required placeholder="Funder Count"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('funder_count')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Rental Income</span>
                <input type="number" class="form-control" name='rental_income' required placeholder="Rental Income"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('rental_income')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Current Rent</span>
                <input type="number" class="form-control" name='current_rent' required placeholder="Current Rent"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('current_rent')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Current Evaluation</span>
                <input type="number" class="form-control" name='current_evaluation' required
                    placeholder="Current Evaluation" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('current_evaluation')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Annual Gross Yield</span>
                <input type="number" class="form-control" name='percent' required placeholder="Annual Gross Yield"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('percent')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Location String</span>
                <input type="text" class="form-control" name='location_string' required placeholder="location"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('location_string')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Property Price</span>
                <input type="number" class="form-control" name='property_price_total' required
                    placeholder="Property Price" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('property_price_total')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Service Charge</span>
                <input type="number" class="form-control" name='service_charge' required placeholder="Service Charge"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('service_charge')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Discount</span>
                <input type="number" class="form-control" name='discount' required placeholder="Discount"
                    aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('discount')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Estimated Annualised Return</span>
                <input type="number" class="form-control" required name='estimated_annualised_return'
                    placeholder="Estimated Annualised Return" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('estimated_annualised_return')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Estimated Annual Appreciation</span>
                <input type="number" class="form-control" required name='estimated_annual_appreciation'
                    placeholder="Estimated Annual Appreciation" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('estimated_annual_appreciation')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Estimated Projected Gross Yield</span>
                <input type="number" class="form-control" required name='estimated_projected_gross_yield'
                    placeholder="Estimated Projected Gross Yield" aria-label="Username"
                    aria-describedby="addon-wrapping">
            </div>
            @error('estimated_projected_gross_yield')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Latitude</span>
                <input type="number" class="form-control" required step="any" name='latitude'
                    placeholder="latitude" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('latitude')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">Longitude</span>
                <input type="number" class="form-control" required step="any" name='longitude'
                    placeholder="longitude" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            @error('longitude')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group flex-nowrap mt-3">
                <select class="form-select form-select-lg mb-3" placeholder="Category Name" name="category_id"
                    aria-label="Large select example" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3 mt-3">
                    {{ $message }}
                </div>
            @enderror

            <input type="submit" value="save" class="btn btn-primary btn-sm">
        </form>
    </div>
@endsection
